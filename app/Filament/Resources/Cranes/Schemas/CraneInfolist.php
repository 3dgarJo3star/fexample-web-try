<?php

namespace App\Filament\Resources\Cranes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CraneInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->label('Nombre'),
                        TextEntry::make('serial_number')->label('Número de Serie')->placeholder('-'),
                        TextEntry::make('brand')->label('Marca'),
                        TextEntry::make('year')->label('Año')->placeholder('-'),
                        TextEntry::make('capacity_tons')->label('Capacidad')->suffix(' ton')->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Estado')
                            ->badge(),
                    ]),

                Section::make('Estado Actual')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('current_location')->label('Ubicación Actual')->placeholder('Sin registrar'),
                        TextEntry::make('diesel_level')->label('Diesel')->suffix('%'),
                        TextEntry::make('total_hours')->label('Horas Totales')->suffix(' hrs'),
                        TextEntry::make('last_maintenance_hours')->label('Horas Último Mant.')->suffix(' hrs'),
                        TextEntry::make('hours_until_maintenance')
                            ->label('Horas Para Próx. Mant.')
                            ->suffix(' hrs')
                            ->state(fn ($record) => number_format(400 - ($record->total_hours - $record->last_maintenance_hours), 2)),
                        IconEntry::make('is_active')->label('Activa')->boolean(),
                    ]),

                Section::make('Notas')
                    ->schema([
                        TextEntry::make('notes')->label('Notas')->placeholder('-')->columnSpanFull(),
                    ]),
            ]);
    }
}
