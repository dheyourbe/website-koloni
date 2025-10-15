<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->required()
                    ->options(Product::getCategoryOptions())
                    ->placeholder('Pilih Kategori'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Produk'),

                Textarea::make('description')
                    ->required()
                    ->rows(3)
                    ->label('Deskripsi'),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Harga')
                    ->step(0.01),

                FileUpload::make('photo')
                    ->label('Foto Produk')
                    ->image()
                    ->directory('products')
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048) // 2MB max
                    ->openable()
                    ->downloadable()
            ]);
    }
}
