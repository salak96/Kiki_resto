<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;
    protected static ?string $navigationGroup = 'KIKI RESTO';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'nama_pelanggan')
                    ->required()
                    ->label('Pelanggan'),

                Forms\Components\TextInput::make('total_harga')
                    ->required()
                    ->numeric()
                    ->label('Total Harga'),

                Forms\Components\Select::make('status')
                    ->options([
                        'dipesan' => 'Dipesan',
                        'dibayar' => 'Dibayar',
                        'batal' => 'Batal',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status'),

                Forms\Components\DateTimePicker::make('waktu_pesan')
                    ->default(now())
                    ->required()
                    ->label('Waktu Pesan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->label('No'),

                Tables\Columns\TextColumn::make('pelanggan.nama_pelanggan')
                    ->searchable()
                    ->sortable()
                    ->label('Pelanggan'),

                Tables\Columns\TextColumn::make('total_harga')
                    ->sortable()
                    ->label('Total Harga')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')), 

                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('waktu_pesan')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Pesan'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->filters([
                Filter::make('Rentang Tanggal')
                    ->form([
                        DatePicker::make('start_date')->label('Dari Tanggal'),
                        DatePicker::make('end_date')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'], fn ($q) => $q->whereDate('waktu_pesan', '>=', $data['start_date']))
                            ->when($data['end_date'], fn ($q) => $q->whereDate('waktu_pesan', '<=', $data['end_date']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
