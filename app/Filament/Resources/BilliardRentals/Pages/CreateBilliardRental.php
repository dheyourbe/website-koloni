<?php

namespace App\Filament\Resources\BilliardRentals\Pages;

use App\Filament\Resources\BilliardRentals\BilliardRentalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBilliardRental extends CreateRecord
{
    protected static string $resource = BilliardRentalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
