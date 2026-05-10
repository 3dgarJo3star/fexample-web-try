<?php

declare(strict_types=1);

namespace App\Filament\Resources\Cranes\Schemas;

use App\Enums\CraneStatus;
use Filament\Forms\Components\{Select, TextInput, Textarea, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CraneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información General')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->description('Datos de identificación de la grúa')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: Grúa Titán 80T'),
                        TextInput::make('serial_number')
                            ->label('Número de Serie')
                            ->maxLength(255)
                            ->placeholder('Ej: TIT-2024-001'),
                        TextInput::make('brand')
                            ->label('Marca')
                            ->default('Titán')
                            ->required(),
                        TextInput::make('year')
                            ->label('Año')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(now()->year + 1),
                        TextInput::make('capacity_tons')
                            ->label('Capacidad')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('ton'),
                        Select::make('status')
                            ->label('Estado')
                            ->options(CraneStatus::class)
                            ->required()
                            ->default(CraneStatus::Available)
                            ->native(false),
                    ]),

                Section::make('Estado Actual')
                    ->icon('heroicon-o-signal')
                    ->description('Indicadores operativos en tiempo real')
                    ->columns(3)
                    ->schema([
                        TextInput::make('current_location')
                            ->label('Ubicación Actual')
                            ->maxLength(255)
                            ->placeholder('Ej: Obra Reforma 222')
                            ->columnSpanFull(),
                        TextInput::make('diesel_level')
                            ->label('Nivel de Diesel')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('total_hours')
                            ->label('Horas Totales')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->helperText('Lectura actual del horómetro'),
                        TextInput::make('last_maintenance_hours')
                            ->label('Horas Último Mant.')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->helperText('Horómetro al último servicio'),
                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger')
                            ->columnSpanFull(),
                    ]),

                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas')
                            ->rows(3)
                            ->placeholder('Observaciones adicionales sobre la grúa...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
