<?php

namespace App\Filament\Resources\BilliardTables;

use App\Filament\Resources\BilliardTables\Pages\CreateBilliardTable;
use App\Filament\Resources\BilliardTables\Pages\EditBilliardTable;
use App\Filament\Resources\BilliardTables\Pages\ListBilliardTables;
use App\Filament\Resources\BilliardTables\Pages\ViewBilliardTable;
use App\Filament\Resources\BilliardTables\Schemas\BilliardTableForm;
use App\Filament\Resources\BilliardTables\Schemas\BilliardTableInfolist;
use App\Filament\Resources\BilliardTables\Tables\BilliardTablesTable;
use App\Models\BilliardTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BilliardTableResource extends Resource
{
    protected static ?string $model = BilliardTable::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static ?string $navigationGroup = 'Billiard Management';
    
    // protected static ?string $navigationLabel = 'Tables';
    
    // protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'table_number';

    public static function form(Schema $schema): Schema
    {
        return BilliardTableForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BilliardTableInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BilliardTablesTable::configure($table);
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
            'index' => ListBilliardTables::route('/'),
            'create' => CreateBilliardTable::route('/create'),
            'view' => ViewBilliardTable::route('/{record}'),
            'edit' => EditBilliardTable::route('/{record}/edit'),
        ];
    }
}
