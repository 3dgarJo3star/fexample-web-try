<?php

declare(strict_types=1);

namespace App\Filament\Resources\Zones\Schemas;

use Filament\Forms\Components\{TextInput, Textarea, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos de la Zona')
                    ->icon('heroicon-o-map-pin')
                    ->description('Defina las zonas geográficas de operación')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre de la Zona')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: Zona Norte, Centro Histórico'),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(2)
                            ->placeholder('Descripción o referencias de la zona...'),
                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),
            ]);
    }
}
