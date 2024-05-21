<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class OrderCustomerChartLine extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $data = Trend::model(Customer::class)
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
        return 'line';
    }
}
