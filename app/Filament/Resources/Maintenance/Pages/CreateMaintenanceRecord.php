<?php

namespace App\Filament\Resources\Maintenance\Pages;

use App\Filament\Resources\Maintenance\MaintenanceResource;
use App\Models\Crane;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRecord extends CreateRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        if ($record->status->value === 'completed') {
            Crane::where('id', $record->crane_id)->update([
                'last_maintenance_hours' => $record->hours_at_maintenance,
            ]);
        }
    }
}
