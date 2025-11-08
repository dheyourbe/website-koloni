<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_wa')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->placeholder('Belum diisi'),

                TextColumn::make('points')
                    ->label('Points')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn (int $state): string => number_format($state)),

                TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('simulate_purchase')
                    ->label('Simulasi Pembelian')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('warning')
                    ->form([
                        TextInput::make('purchase_amount')
                            ->label('Total Pembelian')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(1000)
                            ->default(50000),
                    ])
                    ->action(function (User $record, array $data): void {
                        $purchaseAmount = $data['purchase_amount'];
                        $pointsEarned = (int) ($purchaseAmount * 0.10); // 10% of purchase as points
                        
                        $record->addPoints($pointsEarned);
                        
                        Notification::make()
                            ->title('Simulasi Pembelian Berhasil')
                            ->body("Pengguna {$record->name} mendapat {$pointsEarned} poin dari pembelian Rp " . number_format($purchaseAmount))
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
