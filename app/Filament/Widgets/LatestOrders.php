<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PelangganResource;
use App\Models\Pelanggan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->query(Pelanggan::query()->latest())
            ->columns([
                Tables\Columns\TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_meja')
                    ->label('No Meja')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
            ])->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn (Pelanggan $record): string => PelangganResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}