<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Pelanggan;   

class CustomersChart extends ChartWidget
{
    protected static ?string $heading = 'Pelanggan per Bulan';

    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $customersCount = Pelanggan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => array_values($customersCount),
                    'fill' => 'start',
                ],
            ],
            'labels' => array_keys($customersCount),
        ];
    }
}