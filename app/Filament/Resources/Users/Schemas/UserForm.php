<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Email'),

                TextInput::make('no_wa')
                    ->tel()
                    ->maxLength(255)
                    ->label('No. WhatsApp')
                    ->placeholder('08xxxxxxxxxx'),

                TextInput::make('password')
                    ->password()
                    ->required(fn ($context) => $context === 'create')
                    ->minLength(8)
                    ->maxLength(255)
                    ->label('Password')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->revealable(),

                TextInput::make('points')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->label('Points')
                    ->helperText('Poin pengguna (akan otomatis +20 untuk pengguna baru)'),
            ]);
    }
}
