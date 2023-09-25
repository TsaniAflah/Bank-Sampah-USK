<?php

namespace App\Filament\Widgets;

use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\SetoranItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = '15s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $totalQuantity = SetoranItem::sum('quantity');

        return [
            Stat::make('Total Nasabah', Nasabah::count())
            //->description('Pertambahan nasabah')
            //->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
            //->chart([6, 2, 4, 8, 4, 6, 8]),

            Stat::make('Total Jenis Sampah', JenisSampah::count())
                ->description('Pertambahan nasabah')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->chart([6, 2, 4, 8, 4, 6, 8]),

            Stat::make('Total Berat Sampah', $totalQuantity)
                ->description('Satuan Kilogram')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger')
                ->chart([6, 2, 4, 8, 4, 6, 8]),
        ];
    }

}
