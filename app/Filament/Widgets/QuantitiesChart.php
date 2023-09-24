<?php

namespace App\Filament\Widgets;

use App\Models\JenisSampah;
use App\Models\Setoran;
use App\Models\SetoranItem;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class QuantitiesChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Total Volume Sampah';

    protected function getData(): array
    {
        $data = $this->getQuantitiesPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Quantity',
                    'data' => $data['quantitiesPerMonth']
                ]
            ],
            'labels' => $data['months']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getQuantitiesPerMonth()
    {
        $now = Carbon::now();

        $quantitiesPerMonth = [];
        $months = collect(range(1, 12))->map(function ($month) use ($now, &$quantitiesPerMonth) {
            $count = SetoranItem::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $month)
                ->sum('quantity');
            $quantitiesPerMonth[] = $count;

            return $now->month($month)->format('M');
        })->toArray();

        return [
            'quantitiesPerMonth' => $quantitiesPerMonth,
            'months' => $months
        ];
    }
}
