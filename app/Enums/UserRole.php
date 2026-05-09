<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel, HasColor
{
    case Admin = 'admin';
    case Administrative = 'administrative';
    case Operator = 'operator';
    case Client = 'client';

    public function getLabel(): string
    {
        return match($this) {
            self::Admin => 'Administrador',
            self::Administrative => 'Administrativo',
            self::Operator => 'Operador',
            self::Client => 'Cliente',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Admin => 'danger',
            self::Administrative => 'warning',
            self::Operator => 'info',
            self::Client => 'success',
        };
    }
}
