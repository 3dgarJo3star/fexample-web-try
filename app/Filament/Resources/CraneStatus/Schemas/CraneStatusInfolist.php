<?php

declare(strict_types=1);

namespace App\Filament\Resources\CraneStatus\Schemas;

use Filament\Infolists\Components\{IconEntry, TextEntry};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class CraneStatusInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Grúa y Operador')
                    ->icon('heroicon-o-signal')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('crane.name')
                            ->label('Grúa')
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-o-wrench-screwdriver'),
                        TextEntry::make('operator.name')
                            ->label('Operador')
                            ->placeholder('Sin operador')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('logged_at')
                            ->label('Fecha y Hora')
                            ->dateTime('d/m/Y H:i')
                            ->icon('heroicon-o-clock'),
                    ]),

                Section::make('Estado Operativo')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(2)
                    ->schema([
                        IconEntry::make('is_on')->label('Motor Encendido')->boolean(),
                        IconEntry::make('is_working')->label('En Operación')->boolean(),
                    ]),

                Section::make('Lecturas')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('location')
                            ->label('Ubicación')
                            ->placeholder('Sin registrar')
                            ->icon('heroicon-o-map-pin')
                            ->columnSpanFull(),
                        TextEntry::make('diesel_level')
                            ->label('Diesel')
                            ->suffix('%')
                            ->color(fn ($state): string => match (true) {
                                $state === null => 'gray',
                                $state <= 20 => 'danger',
                                $state <= 50 => 'warning',
                                default => 'success',
                            }),
                        TextEntry::make('hours_reading')
                            ->label('Horómetro')
                            ->suffix(' hrs')
                            ->placeholder('-'),
                    ]),

                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notes')->label('Notas')->placeholder('Sin notas')->columnSpanFull(),
                    ]),
            ]);
    }
}
