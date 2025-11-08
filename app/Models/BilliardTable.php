<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BilliardRental; // <-- PENTING: Tambahkan import ini
use Carbon\Carbon; // <-- PENTING: Tambahkan import ini

class BilliardTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'photo',
        'name',
        'description',
    ];

    /**
     * Get the rentals for this billiard table.
     */
    public function rentals()
    {
        return $this->hasMany(BilliardRental::class);
    }

    /**
     * TODO: Implementasi ini juga harusnya mengecek rental_start
     */
    public function isOccupied(): bool
    {
        // Cek apakah ada rental yang SEDANG BERLANGSUNG SAAT INI
        return $this->rentals()
            ->whereIn('status', [BilliardRental::STATUS_PAID, BilliardRental::STATUS_PENDING])
            ->where('rental_start', '<=', now()) // Sudah dimulai
            ->where('rental_end', '>', now())  // Belum selesai
            ->exists();
    }

    /**
     * FUNGSI YANG DIPERBAIKI:
     * Cek ketersediaan meja pada rentang waktu yang diminta.
     */
    public function isAvailableAt(Carbon $startTime, Carbon $endTime): bool
    {
        // Ambil status aktif dari model BilliardRental
        // Kita harus mengecek 'pending' DAN 'paid',
        // karena 'pending' berarti sudah dibooking tapi belum dibayar.
        $activeStatuses = [
            BilliardRental::STATUS_PENDING,
            BilliardRental::STATUS_PAID,
        ];

        // Cek untuk setiap booking yang tumpang tindih (konflik)
        $conflictingBookings = $this->rentals()
            ->whereIn('status', $activeStatuses) // Hanya cek booking yang aktif
            ->where(function ($query) use ($startTime, $endTime) {
                // Logika overlap:
                // (Waktu Mulai Lama < Waktu Selesai Baru) DAN (Waktu Selesai Lama > Waktu Mulai Baru)
                $query->where('rental_start', '<', $endTime)
                    ->where('rental_end', '>', $startTime);
            })
            ->exists(); // 'exists()' adalah cara tercepat untuk cek

        // Kembalikan kebalikannya:
        // Jika ada konflik (true), maka meja TIDAK tersedia (return false)
        // Jika tidak ada konflik (false), maka meja TERSEDIA (return true)
        return !$conflictingBookings;
    }

    /**
     * Get available time slots for a specific date.
     * TODO: Implement when time slot system is needed
     */
    /*
    public function getAvailableSlots(\Carbon\Carbon $date, int $durationHours): array
    {
        $availableSlots = [];
        $openingHour = 9; // 9 AM
        $closingHour = 22; // 10 PM

        for ($hour = $openingHour; $hour <= ($closingHour - $durationHours); $hour++) {
            $slotStart = $date->copy()->setHour($hour)->setMinute(0)->setSecond(0);
            $slotEnd = $slotStart->copy()->addHours($durationHours);

            if ($this->isAvailableAt($slotStart, $slotEnd)) {
                $availableSlots[] = [
                    'time' => $slotStart->format('H:i'),
                    'datetime' => $slotStart,
                ];
            }
        }

        return $availableSlots;
    }
    */
}
