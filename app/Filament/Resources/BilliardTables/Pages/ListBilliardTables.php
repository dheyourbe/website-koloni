<?php

namespace App\Filament\Resources\BilliardTables\Pages;

use App\Filament\Resources\BilliardTables\BilliardTableResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBilliardTables extends ListRecords
{
    protected static string $resource = BilliardTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
