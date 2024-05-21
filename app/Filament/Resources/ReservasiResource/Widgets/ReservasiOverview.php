<?php

namespace App\Filament\Resources\ReservasiResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservasiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Orders", '100')
                ->description('Jumlah Pesanan Meningkat 32%')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([1, 8, 18, 20, 11, 30])
                ->color('success'),
            Stat::make("New Order", '100')
                ->description('Pesanan Baru')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make("Today's Order Revenue", '100')
                ->description('Pendapatan Pemesanan Hari Ini')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([1, 8, 18, 20, 7, 2])
                ->color('danger'),
        ];
    }
}
