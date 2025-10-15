<?php

namespace App\Filament\Resources\BilliardRentals\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use App\Models\BilliardTable;
use App\Models\BilliardRental;

class BilliardRentalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('billiard_table_id')
                    ->label('Billiard Table')
                    ->required()
                    ->relationship('billiardTable', 'table_number')
                    ->searchable()
                    ->preload()
                    ->helperText('Select the table to be rented'),

                TextInput::make('customer_name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter customer full name')
                    ->helperText('Name of the person renting the table'),

                TextInput::make('customer_whatsapp')
                    ->label('Customer WhatsApp')
                    ->tel()
                    ->maxLength(20)
                    ->placeholder('e.g., +62812-3456-7890')
                    ->helperText('WhatsApp number for receipt (optional)'),

                Select::make('duration_hours')
                    ->label('Duration (Hours)')
                    ->required()
                    ->options(array_combine(range(1, 24), array_map(fn($h) => "$h " . ($h == 1 ? 'hour' : 'hours'), range(1, 24))))
                    ->default(1)
                    ->helperText('How many hours to rent the table'),

                DateTimePicker::make('rental_start')
                    ->label('Start Time')
                    ->required()
                    ->seconds(false)
                    ->helperText('When the rental period begins'),

                TextInput::make('price_per_hour')
                    ->label('Price per Hour (Rp)')
                    ->required()
                    ->numeric()
                    ->default(120000)
                    ->minValue(0)
                    ->step(1000)
                    ->helperText('Rate per hour in Indonesian Rupiah'),

                TextInput::make('total_amount')
                    ->label('Total Amount (Rp)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(1000)
                    ->placeholder('Will be calculated automatically')
                    ->helperText('Total rental cost (calculated from duration × price per hour)'),

                Select::make('status')
                    ->label('Rental Status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->helperText('Current status of the rental'),

                Hidden::make('subtotal')
                    ->default(0),

                Hidden::make('discount_amount')
                    ->default(0),
            ]);
    }
}
