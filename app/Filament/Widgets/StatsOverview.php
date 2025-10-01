<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $regularUsers = User::where('is_admin', false);
        
        return [
            Stat::make('Total Users', $regularUsers->count())
                ->description('Regular users registered')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Products', Product::count())
                ->description('Products available')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('Total Points', number_format(User::sum('points')))
                ->description('Points accumulated across all users')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Avg Points per User', number_format($regularUsers->avg('points') ?? 0, 1))
                ->description('Average points per regular user')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
