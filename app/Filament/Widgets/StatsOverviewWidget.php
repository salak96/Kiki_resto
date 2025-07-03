<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pesanan;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = is_null($this->filters['startDate'] ?? null)
            ? null
            : Carbon::parse($this->filters['startDate']);

        $endDate = is_null($this->filters['endDate'] ?? null)
            ? now()
            : Carbon::parse($this->filters['endDate']);

        // Hitung total pemasukan dari pesanan yang sudah dibayar dalam rentang waktu
        $pemasukan = Pesanan::where('status', 'dibayar')
            ->whereBetween('waktu_pesan', [$startDate, $endDate])
            ->sum('total_harga');

        // Jika kamu punya logika pengeluaran, sesuaikan ini
        $pengeluaran = 0; // Default, atau ambil dari model lain jika ada

        $selisih = $pemasukan - $pengeluaran;

        return [
            Stat::make('Total Pemasukan', 'Rp ' . number_format($pemasukan, 0, ',', '.')),
            Stat::make('Total Pengeluaran', 'Rp ' . number_format($pengeluaran, 0, ',', '.')),
            Stat::make('Selisih', 'Rp ' . number_format($selisih, 0, ',', '.')),
        ];
    }
}
