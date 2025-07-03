<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pesanan;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Pesanan per Bulan';

    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $ordersCount = Pesanan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Pesanan',
                    'data' => array_values($ordersCount),
                    'fill' => 'start',
                ],
            ],
            'labels' => array_keys($ordersCount),
        ];
    }
}