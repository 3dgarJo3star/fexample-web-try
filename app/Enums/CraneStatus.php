<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CraneStatus: string implements HasLabel, HasColor, HasIcon
{
    case Available = 'available';
    case Working = 'working';
    case Maintenance = 'maintenance';
    case Inactive = 'inactive';

    public function getLabel(): string
    {
        return match($this) {
            self::Available => 'Disponible',
            self::Working => 'En Operación',
            self::Maintenance => 'En Mantenimiento',
            self::Inactive => 'Inactiva',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Available => 'success',
            self::Working => 'warning',
            self::Maintenance => 'danger',
            self::Inactive => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::Available => 'heroicon-o-check-circle',
            self::Working => 'heroicon-o-cog-6-tooth',
            self::Maintenance => 'heroicon-o-wrench-screwdriver',
            self::Inactive => 'heroicon-o-x-circle',
        };
    }
}
