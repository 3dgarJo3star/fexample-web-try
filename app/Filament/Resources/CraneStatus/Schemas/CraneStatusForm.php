<?php

namespace App\Filament\Resources\CraneStatus\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CraneStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Registro de Estado')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('operator_id')
                            ->label('Operador')
                            ->relationship('operator', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Toggle::make('is_on')
                            ->label('Motor Encendido')
                            ->default(false),
                        Toggle::make('is_working')
                            ->label('En Operación (Trabajando)')
                            ->default(false),
                        TextInput::make('location')
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
                        TextInput::make('hours_reading')
                            ->label('Lectura de Horas (Horómetro)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs'),
                        DateTimePicker::make('logged_at')
                            ->label('Fecha y Hora del Registro')
                            ->required()
                            ->default(now()),
                        Textarea::make('notes')
                            ->label('Notas')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
