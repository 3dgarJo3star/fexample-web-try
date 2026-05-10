<?php

namespace App\Filament\Resources\RentalOrders\Pages;

use App\Filament\Resources\RentalOrders\RentalOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRentalOrder extends EditRecord
{
    protected static string $resource = RentalOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [ViewAction::make(), DeleteAction::make()];
    }
}
