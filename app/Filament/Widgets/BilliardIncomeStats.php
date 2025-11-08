<?php

namespace App\Filament\Widgets;

use App\Models\BilliardRental;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class BilliardIncomeStats extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Menghitung Total Pemasukan (hanya yang 'paid')
        $totalIncome = BilliardRental::where('status', 'paid')->sum('total_amount');

        // 2. Menghitung Jumlah Pesanan Lunas
        $paidOrders = BilliardRental::where('status', 'paid')->count();

        // 3. (Opsional) Menghitung Pemasukan Hari Ini
        $todayIncome = BilliardRental::where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_amount');

        return [
            Stat::make('Total Pemasukan', 'Rp ' . Number::format($totalIncome, 0, 0, 'id'))
                ->description('Semua pemasukan yang sudah lunas')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Pesanan Lunas', $paidOrders)
                ->description('Jumlah total pesanan lunas')
                ->color('info')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Pemasukan Hari Ini', 'Rp ' . Number::format($todayIncome, 0, 0, 'id'))
                ->description('Pemasukan lunas hari ini')
                ->color('success')
                ->icon('heroicon-o-calendar-days'),
        ];
    }
}
