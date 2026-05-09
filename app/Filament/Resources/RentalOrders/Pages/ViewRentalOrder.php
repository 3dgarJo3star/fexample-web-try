<?php

namespace App\Filament\Resources\RentalOrders\Pages;

use App\Filament\Resources\RentalOrders\RentalOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRentalOrder extends ViewRecord
{
    protected static string $resource = RentalOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
