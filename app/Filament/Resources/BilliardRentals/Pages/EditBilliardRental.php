<?php

namespace App\Filament\Resources\BilliardRentals\Pages;

use App\Filament\Resources\BilliardRentals\BilliardRentalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBilliardRental extends EditRecord
{
    protected static string $resource = BilliardRentalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
