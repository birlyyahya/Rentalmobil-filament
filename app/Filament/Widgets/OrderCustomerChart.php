<?php

namespace App\Filament\Widgets;

use App\Models\Reservasi;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class OrderCustomerChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '10s';

    protected function getData(): array
    {
        $data = Trend::model(Reservasi::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
