<?php

namespace App\Filament\Resources\Maintenance\Pages;

use App\Filament\Resources\Maintenance\MaintenanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaintenanceRecord extends ViewRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
