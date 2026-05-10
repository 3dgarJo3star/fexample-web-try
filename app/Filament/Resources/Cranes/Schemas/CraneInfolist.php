<?php

declare(strict_types=1);

namespace App\Filament\Resources\Cranes\Schemas;

use Filament\Infolists\Components\{IconEntry, TextEntry};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class CraneInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información General')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre')
                            ->weight(FontWeight::Bold)
                            ->copyable(),
                        TextEntry::make('serial_number')->label('Número de Serie')->placeholder('-')->copyable(),
                        TextEntry::make('brand')->label('Marca'),
                        TextEntry::make('year')->label('Año')->placeholder('-'),
                        TextEntry::make('capacity_tons')->label('Capacidad')->suffix(' ton')->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Estado')
                            ->badge(),
                    ]),

                Section::make('Estado Actual')
                    ->icon('heroicon-o-signal')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('current_location')
                            ->label('Ubicación Actual')
                            ->placeholder('Sin registrar')
                            ->icon('heroicon-o-map-pin')
                            ->columnSpanFull(),
                        TextEntry::make('diesel_level')
                            ->label('Diesel')
                            ->suffix('%')
                            ->color(fn ($state): string => match (true) {
                                $state <= 20 => 'danger',
                                $state <= 50 => 'warning',
                                default => 'success',
                            }),
                        TextEntry::make('total_hours')->label('Horas Totales')->suffix(' hrs'),
                        TextEntry::make('last_maintenance_hours')->label('Horas Último Mant.')->suffix(' hrs'),
                        TextEntry::make('hours_until_maintenance')
                            ->label('Horas Para Próx. Mant.')
                            ->suffix(' hrs')
                            ->state(fn ($record) => number_format(400 - ($record->total_hours - $record->last_maintenance_hours), 2))
                            ->color(fn ($record): string => match (true) {
                                ($record->total_hours - $record->last_maintenance_hours) >= 400 => 'danger',
                                ($record->total_hours - $record->last_maintenance_hours) >= 350 => 'warning',
                                default => 'success',
                            }),
                        IconEntry::make('is_active')->label('Activa')->boolean(),
                    ]),

                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notes')->label('Notas')->placeholder('Sin notas registradas')->columnSpanFull(),
                    ]),
            ]);
    }
}
