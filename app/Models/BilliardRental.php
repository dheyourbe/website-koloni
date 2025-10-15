<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BilliardRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'billiard_table_id',
        'user_id',
        'customer_name',
        'customer_whatsapp',
        'duration_hours',
        'price_per_hour',
        'subtotal',
        'discount_amount',
        'total_amount',
        'status',
        'receipt_pdf_path',
        'receipt_image_path',
        'rental_start',
        'rental_end',
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'rental_start' => 'datetime',
        'rental_end' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_REJECTED = 'rejected';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rental) {
            if (empty($rental->transaction_number)) {
                $rental->transaction_number = 'BLR-' . date('Ymd') . '-' . Str::random(6);
            }

            // Auto-calculate rental_end based on rental_start + duration_hours
            if ($rental->rental_start && $rental->duration_hours) {
                $durationHours = (int) $rental->duration_hours;
                $rental->rental_end = \Carbon\Carbon::parse($rental->rental_start)
                    ->addHours($durationHours);
            }

            // Auto-calculate pricing if not set
            if (!$rental->price_per_hour) {
                $rental->price_per_hour = 120000;
            }

            if ($rental->duration_hours && $rental->price_per_hour) {
                $pricing = self::calculatePrice(
                    $rental->duration_hours,
                    $rental->user_id ? true : false // Check if user is member
                );

                $rental->subtotal = $pricing['subtotal'];
                $rental->discount_amount = $pricing['discount_amount'];
                $rental->total_amount = $pricing['total_amount'];
            }
        });

        static::updating(function ($rental) {
            // Auto-calculate rental_end based on rental_start + duration_hours
            if ($rental->rental_start && $rental->duration_hours) {
                $durationHours = (int) $rental->duration_hours;
                $rental->rental_end = \Carbon\Carbon::parse($rental->rental_start)
                    ->addHours($durationHours);
            }

            // Auto-calculate pricing when relevant fields change
            if ($rental->isDirty(['duration_hours', 'price_per_hour', 'user_id'])) {
                if ($rental->duration_hours && $rental->price_per_hour) {
                    $pricing = self::calculatePrice(
                        $rental->duration_hours,
                        $rental->user_id ? true : false
                    );

                    $rental->subtotal = $pricing['subtotal'];
                    $rental->discount_amount = $pricing['discount_amount'];
                    $rental->total_amount = $pricing['total_amount'];
                }
            }
        });

        static::updated(function ($rental) {
            // Regenerate receipt when status changes
            if ($rental->isDirty('status') && $rental->receipt_pdf_path) {
                try {
                    $receiptService = app(\App\Services\ReceiptService::class);
                    $receiptService->generateReceipt($rental);
                } catch (\Exception $e) {
                    // Log error but don't fail the update
                    Log::error('Failed to regenerate receipt: ' . $e->getMessage());
                }
            }
        });
    }

    /**
     * Get the billiard table associated with this rental.
     */
    public function billiardTable()
    {
        return $this->belongsTo(BilliardTable::class);
    }

    /**
     * Get the user associated with this rental.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate the total price based on hours, member status, and custom price per hour.
     */
    public static function calculatePrice(int $hours, bool $isMember = false, ?float $customPricePerHour = null): array
    {
        $pricePerHour = $customPricePerHour ?? 120000; // Rp 120,000 default
        $subtotal = $pricePerHour * $hours;
        $discountAmount = $isMember ? $subtotal * 0.10 : 0; // 10% discount for members
        $totalAmount = $subtotal - $discountAmount;

        return [
            'price_per_hour' => $pricePerHour,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
        ];
    }

    /**
     * Get the status color for display.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PAID => 'success',
            self::STATUS_REJECTED => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get the status label for display.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Lunas',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Unknown',
        };
    }
}
