<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MaintenanceType: string implements HasLabel
{
    case Preventive = 'preventive';
    case Corrective = 'corrective';
    case Inspection = 'inspection';

    public function getLabel(): string
    {
        return match($this) {
            self::Preventive => 'Preventivo',
            self::Corrective => 'Correctivo',
            self::Inspection => 'Inspección',
        };
    }
}
