<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Cash = 'cash';
    case Credit = 'credit';

    public function getLabel(): string
    {
        return match($this) {
            self::Cash => 'Contado (Efectivo)',
            self::Credit => 'Crédito (Transferencia)',
        };
    }
}
