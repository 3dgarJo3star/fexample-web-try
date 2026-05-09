<?php

namespace App\Filament\Resources\Cranes\Schemas;

use App\Enums\CraneStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CraneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información General')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('serial_number')
                            ->label('Número de Serie')
                            ->maxLength(255),
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
                            ->label('Capacidad (Toneladas)')
                            ->numeric()
                            ->step(0.01),
                        Select::make('status')
                            ->label('Estado')
                            ->options(CraneStatus::class)
                            ->required()
                            ->default(CraneStatus::Available),
                    ]),

                Section::make('Estado Actual')
                    ->columns(2)
                    ->schema([
                        TextInput::make('current_location')
                            ->label('Ubicación Actual')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('diesel_level')
                            ->label('Nivel de Diesel (%)')
                            ->numeric()
                            ->step(0.01)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                        TextInput::make('total_hours')
                            ->label('Horas Totales')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs'),
                        TextInput::make('last_maintenance_hours')
                            ->label('Horas en Último Mantenimiento')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs'),
                        Toggle::make('is_active')
                            ->label('Activa')
                            ->default(true),
                    ]),

                Section::make('Notas')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
