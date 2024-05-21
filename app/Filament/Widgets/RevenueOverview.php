<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RevenueOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Revenue", "10000")
                ->description('Pendapatan Meningkat 32%')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make("New Customer", "10")->description('Pelanggan Baru Bertambah 5%')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make("New Orders", "10")
                ->description('Pesanan Per Bulan Berkurang 10%')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([1, 8, 18, 20, 7, 2])
                ->color('danger'),
        ];
    }
}
