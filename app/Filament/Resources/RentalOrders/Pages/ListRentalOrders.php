<?php

namespace App\Filament\Resources\RentalOrders\Pages;

use App\Filament\Resources\RentalOrders\RentalOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRentalOrders extends ListRecords
{
    protected static string $resource = RentalOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Nueva Orden')];
    }
}
