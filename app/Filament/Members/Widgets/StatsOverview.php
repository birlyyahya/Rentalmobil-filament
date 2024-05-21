<?php

namespace App\Filament\Members\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Orders", "20")
                ->description('Jumlah pesanan yang ada')
                ->color('success'),
            Stat::make("Unpaid Orders", "1")
                ->description('Selesaikan pembayaran anda')
                ->color('warning'),
            Stat::make("Cancelled Orders", "1")
                ->description('Jumlah pesanan dibatalkan')
                ->color('danger'),
        ];
    }
}
