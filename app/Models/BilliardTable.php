<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Get the current active rental for this table.
     */
    public function activeRental()
    {
        return $this->hasOne(BilliardRental::class)
            ->where('status', 'paid')
            ->where('rental_end', '>', now());
    }

    /**
     * Check if the table is currently occupied.
     */
    public function isOccupied(): bool
    {
        return $this->activeRental()->exists();
    }

    /**
     * Check if the table is available for booking at a specific time range.
     */
    public function isAvailableAt(\Carbon\Carbon $startTime, \Carbon\Carbon $endTime): bool
    {
        
        // Check for any paid bookings that overlap with the requested time
        $conflictingBookings = $this->rentals()
            ->where('status', 'paid')
            ->where(function ($query) use ($startTime, $endTime) {
                // Booking starts before our end time and ends after our start time
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('rental_start', '<', $endTime)
                      ->where('rental_end', '>', $startTime);
                });
            })
            ->exists();
            
        return !$conflictingBookings;
    }

    /**
     * Get available time slots for a specific date.
     */
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
}
