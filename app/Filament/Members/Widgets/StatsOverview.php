<?php

namespace App\Filament\Members\Widgets;

use App\Models\Reservasi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Orders", Reservasi::query()->where('customer_id',auth()->user()->id)->count())
                ->description('Jumlah pesanan yang ada')
                ->color('success'),
            Stat::make("Unpaid Orders",Reservasi::query()->where('customer_id', auth()->user()->id)->where('status_pembayaran','unpaid')->count())
                ->description('Selesaikan pembayaran anda')
                ->color('warning'),
            Stat::make("Waiting Confirmation And Pending Orders", Reservasi::query()->where('customer_id', auth()->user()->id)->where('status_reservasi', 'menunggu')->orWhere('status_reservasi', 'pending')->count())
                ->description('Jumlah pesanan sedang menunggu diproses dan Pending')
                ->color('danger'),
        ];
    }
}
