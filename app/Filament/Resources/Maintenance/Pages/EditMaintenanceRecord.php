<?php

namespace App\Filament\Resources\Maintenance\Pages;

use App\Filament\Resources\Maintenance\MaintenanceResource;
use App\Models\Crane;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceRecord extends EditRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [ViewAction::make(), DeleteAction::make()];
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        if ($record->status->value === 'completed') {
            Crane::where('id', $record->crane_id)->update([
                'last_maintenance_hours' => $record->hours_at_maintenance,
            ]);
        }
    }
}
