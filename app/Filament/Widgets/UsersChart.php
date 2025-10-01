<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UsersChart extends ChartWidget
{
    protected ?string $heading = 'Pertumbuhan Pengguna (6 Bulan Terakhir)';

    protected function getData(): array
    {
        $data = collect();
        
        // Get data for last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $usersCount = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
                
            $data->push([
                'month' => $month->format('M Y'),
                'users' => $usersCount,
            ]);
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $data->pluck('users')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
