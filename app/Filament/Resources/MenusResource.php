<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenusResource\Pages;
use App\Filament\Resources\MenusResource\RelationManagers;
use App\Models\Menu;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions;

class MenusResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-minus';
    protected static ?string $navigationGroup = 'KIKI RESTO';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // FORM NOTES:
                
                Forms\Components\TextInput::make('nama_menu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('kategori')
                    ->options([
                        'Makanan' => 'Makanan',
                        'Minuman' => 'Minuman',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('tersedia')
                    ->default(true),
                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->required(),   
                Forms\Components\Textarea::make('deskripsi')
                    ->required(),
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
                Tables\Columns\TextColumn::make('nama_menu')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga')
                    ->sortable()
                    ->label('Harga')    
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('kategori')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('tersedia')
                    ->label('Tersedia'),
                Tables\Columns\ImageColumn::make('gambar')
                    ->circular()
                    ->size(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMenuses::route('/'),
            'create' => Pages\CreateMenus::route('/create'),
            'edit' => Pages\EditMenus::route('/{record}/edit'),
        ];
    }
}
