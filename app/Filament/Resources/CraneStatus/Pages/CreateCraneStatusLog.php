<?php

namespace App\Filament\Resources\CraneStatus\Pages;

use App\Filament\Resources\CraneStatus\CraneStatusResource;
use App\Models\Crane;
use Filament\Resources\Pages\CreateRecord;

class CreateCraneStatusLog extends CreateRecord
{
    protected static string $resource = CraneStatusResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();

        $updates = [
            'current_location' => $record->location ?? null,
            'diesel_level' => $record->diesel_level,
        ];

        if ($record->hours_reading) {
            $updates['total_hours'] = $record->hours_reading;
        }

        if ($record->is_on && $record->is_working) {
            $updates['status'] = 'working';
        } elseif ($record->is_on) {
            $updates['status'] = 'available';
        }

        Crane::where('id', $record->crane_id)->update($updates);
    }
}
