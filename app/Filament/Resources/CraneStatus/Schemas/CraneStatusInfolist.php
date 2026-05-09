<?php

namespace App\Filament\Resources\CraneStatus\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CraneStatusInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registro de Estado')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('crane.name')->label('Grúa'),
                        TextEntry::make('operator.name')->label('Operador')->placeholder('Sin operador'),
                        TextEntry::make('logged_at')->label('Fecha y Hora')->dateTime('d/m/Y H:i'),
                        IconEntry::make('is_on')->label('Motor Encendido')->boolean(),
                        IconEntry::make('is_working')->label('En Operación')->boolean(),
                        TextEntry::make('diesel_level')->label('Diesel')->suffix('%'),
                        TextEntry::make('location')->label('Ubicación')->placeholder('Sin registrar')->columnSpanFull(),
                        TextEntry::make('hours_reading')->label('Horómetro')->suffix(' hrs')->placeholder('-'),
                        TextEntry::make('notes')->label('Notas')->placeholder('-')->columnSpanFull(),
                    ]),
            ]);
    }
}
