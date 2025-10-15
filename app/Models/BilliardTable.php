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
     * Temporary method to always return false (table is available)
     * TODO: Replace with actual occupancy check when system is implemented
     */
    public function isOccupied(): bool
    {
        // Original implementation commented out:
        /*
        return $this->hasOne(BilliardRental::class)
            ->where('status', 'paid')
            ->where('rental_end', '>', now())
            ->exists();
        */

        return false;
    }

    /**
     * Temporary method to always return true (table is available)
     * TODO: Replace with actual availability check when system is implemented
     */
    public function isAvailableAt(\Carbon\Carbon $startTime, \Carbon\Carbon $endTime): bool
    {
        // Original implementation commented out:
        /*
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
        */

        return true;
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
