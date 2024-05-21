<?php

namespace App\Filament\Resources\MobilResource\Widgets;

use App\Models\Mobil;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MobilOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Mobil', Mobil::query()->count())
                ->description('Jumlah seluruh mobil'),
            Stat::make('Mobil Away', Mobil::query()->where('status', 'away')->count())
                ->description('Jumlah mobil berjalan'),
            Stat::make('Mobil Ready', Mobil::query()->where('status', 'ready')->count())
                ->description('Jumlah mobil ready'),
        ];
    }
}
