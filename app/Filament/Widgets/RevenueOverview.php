<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Reservasi;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class RevenueOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $monthlyRevenueData = $this->getMonthlyRevenueData();

        return [
            Stat::make("Revenue", Reservasi::query()->sum('total_bayar'))
                ->description('Pendapatan Meningkat')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([$monthlyRevenueData])
                ->color('success'),
            Stat::make("New Customer", Customer::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count())
                ->description('Pelanggan Baru Bertambah')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make("New Orders", Reservasi::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count())
                ->description('Pesanan Per Bulan Bertambah')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([1, 8, 18, 20, 7, 2])
                ->color('success'),
        ];
    }

    protected function getMonthlyRevenueData(): array
    {
        $currentYear = Carbon::now()->year;

        $monthlyRevenue = Reservasi::selectRaw('MONTH(created_at) as month, SUM(total_bayar) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Inisialisasi pendapatan per bulan dengan nilai 0
        $monthlyRevenueData = array_fill(1, 12, 0);

        // Isi pendapatan yang sebenarnya ke dalam array
        foreach ($monthlyRevenue as $month => $total) {
            $monthlyRevenueData[$month - 1] = $total; // Sesuaikan indeks (array dimulai dari 0)
        }

        return $monthlyRevenueData;
    }
}
