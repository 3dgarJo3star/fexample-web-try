<?php

namespace App\Filament\Resources\Maintenance\Pages;

use App\Filament\Resources\Maintenance\MaintenanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceRecords extends ListRecords
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Registrar Mantenimiento')];
    }
}
