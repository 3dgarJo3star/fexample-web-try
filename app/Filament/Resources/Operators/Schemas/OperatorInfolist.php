<?php

namespace App\Filament\Resources\Operators\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OperatorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Nombre'),
                TextEntry::make('phone')->label('Teléfono')->placeholder('-'),
                TextEntry::make('license_number')->label('No. Licencia')->placeholder('-'),
                TextEntry::make('user.name')->label('Usuario del Sistema')->placeholder('Sin usuario'),
                IconEntry::make('is_active')->label('Activo')->boolean(),
            ]);
    }
}
