<?php

namespace App\Filament\Resources\BilliardTables\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
// use Filament\Tables\Columns\ImageColumn; // Commented out - no images
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BilliardTablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('table_number')
                    ->label('Table Number')
                    ->searchable()
                    ->sortable(),
                    
                // ImageColumn::make('photo') // Commented out - no images
                //     ->label('Photo')
                //     ->circular()
                //     ->size(40)
                //     ->defaultImageUrl(asset('images/default-table.png')),
                    
                TextColumn::make('name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No name set'),
                    
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->placeholder('No description'),
                    
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
