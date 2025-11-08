<?php

namespace App\Filament\Resources\BilliardRentals\Pages;

use App\Filament\Resources\BilliardRentals\BilliardRentalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBilliardRental extends ViewRecord
{
    protected static string $resource = BilliardRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
