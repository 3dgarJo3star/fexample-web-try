<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MaintenanceStatus: string implements HasLabel, HasColor
{
    case Pending = 'pending';
    case Completed = 'completed';

    public function getLabel(): string
    {
        return match($this) {
            self::Pending => 'Pendiente',
            self::Completed => 'Completado',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Completed => 'success',
        };
    }
}
