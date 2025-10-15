<?php

namespace App\Filament\Resources\BilliardRentals;

use App\Filament\Resources\BilliardRentals\Pages\CreateBilliardRental;
use App\Filament\Resources\BilliardRentals\Pages\EditBilliardRental;
use App\Filament\Resources\BilliardRentals\Pages\ListBilliardRentals;
use App\Filament\Resources\BilliardRentals\Pages\ViewBilliardRental;
use App\Filament\Resources\BilliardRentals\Schemas\BilliardRentalForm;
use App\Filament\Resources\BilliardRentals\Schemas\BilliardRentalInfolist;
use App\Filament\Resources\BilliardRentals\Tables\BilliardRentalsTable;
use App\Models\BilliardRental;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BilliardRentalResource extends Resource
{
    protected static ?string $model = BilliardRental::class;

    // protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    // protected static ?string $navigationGroup = 'Billiard Management';

    // protected static ?string $navigationLabel = 'Billiard Rentals';

    // protected static ?int $navigationSort = 2;

    // protected static ?string $slug = 'billiard-rentals';

    protected static ?string $recordTitleAttribute = 'customer_name';

    public static function form(Schema $schema): Schema
    {
        return BilliardRentalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BilliardRentalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BilliardRentalsTable::configure($table);
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
            'index' => ListBilliardRentals::route('/'),
            'create' => CreateBilliardRental::route('/create'),
            'view' => ViewBilliardRental::route('/{record}'),
            'edit' => EditBilliardRental::route('/{record}/edit'),
        ];
    }
}
