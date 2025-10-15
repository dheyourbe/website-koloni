<?php

namespace App\Filament\Resources\BilliardRentals\Pages;

use App\Filament\Resources\BilliardRentals\BilliardRentalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBilliardRentals extends ListRecords
{
    protected static string $resource = BilliardRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
