<?php

namespace App\Filament\Resources\BilliardRentals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BilliardRentalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_number')
                    ->label('Transaction')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('billiardTable.table_number')
                    ->label('Table')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('customer_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(),
                    
                TextColumn::make('rental_start')
                    ->label('Start Time')
                    ->dateTime()
                    ->sortable(),
                    
                TextColumn::make('duration_hours')
                    ->label('Duration')
                    ->suffix(' hours')
                    ->sortable(),
                    
                TextColumn::make('price_per_hour')
                    ->label('Rate/Hour')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                    
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ]),
                    
                SelectFilter::make('billiard_table_id')
                    ->label('Table')
                    ->relationship('billiardTable', 'table_number')
                    ->searchable()
                    ->preload(),
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
