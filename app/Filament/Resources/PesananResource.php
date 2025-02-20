<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->relationship('pelanggan', 'nama')
                    ->required()
                    ->label('Pelanggan'),

                Forms\Components\Select::make('menu_id')
                    ->relationship('menu', 'nama_menu')
                    ->required()
                    ->label('Menu')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('harga_menu', \App\Models\Menu::find($state)?->harga ?? 0)
                    ),

                Forms\Components\TextInput::make('harga_menu')
                    ->label('Harga Menu')
                    ->disabled(),

                Forms\Components\TextInput::make('jumlah_pesanan')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => 
                        $set('total_harga', ($get('harga_menu') ?? 0) * ($state ?? 0))
                    )
                    ->label('Jumlah Pesanan'),

                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->disabled()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama'),
                Tables\Columns\TextColumn::make('menu.nama_menu'),
                Tables\Columns\TextColumn::make('jumlah_pesanan'),
                Tables\Columns\TextColumn::make('total_harga')->money('IDR'),
            ])
            ->filters([
                //
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
