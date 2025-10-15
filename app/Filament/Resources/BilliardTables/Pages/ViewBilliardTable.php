<?php

namespace App\Filament\Resources\BilliardTables\Pages;

use App\Filament\Resources\BilliardTables\BilliardTableResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBilliardTable extends ViewRecord
{
    protected static string $resource = BilliardTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
