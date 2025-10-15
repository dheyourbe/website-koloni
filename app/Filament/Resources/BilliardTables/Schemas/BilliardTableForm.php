<?php

namespace App\Filament\Resources\BilliardTables\Schemas;

use Filament\Schemas\Schema;
// use Filament\Forms\Components\FileUpload; // Commented out - no images
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BilliardTableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('table_number')
                    ->label('Table Number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('e.g., Table 1, Meja A')
                    ->helperText('Unique identifier for this table'),

                // FileUpload::make('photo') // Commented out - no images
                //     ->label('Table Photo')
                //     ->image()
                //     ->maxSize(2048) // 2MB max
                //     ->directory('billiard-tables')
                //     ->visibility('public')
                //     ->helperText('Upload a photo of the billiard table (max 2MB)'),

                TextInput::make('name')
                    ->label('Display Name')
                    ->maxLength(255)
                    ->placeholder('e.g., VIP Table, Premium Billiard')
                    ->helperText('Optional display name for the table'),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->placeholder('Describe the table features, condition, or any special notes...')
                    ->helperText('Optional description of the table'),
            ]);
    }
}
