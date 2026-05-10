<?php

declare(strict_types=1);

namespace App\Filament\Resources\CraneStatus\Schemas;

use Filament\Forms\Components\{DateTimePicker, Select, TextInput, Textarea, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CraneStatusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Grúa y Operador')
                    ->icon('heroicon-o-signal')
                    ->description('Identifique la grúa y el operador que reporta')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        Select::make('operator_id')
                            ->label('Operador')
                            ->relationship('operator', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->native(false),
                        DateTimePicker::make('logged_at')
                            ->label('Fecha y Hora del Registro')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->columnSpanFull(),
                    ]),

                Section::make('Estado Operativo')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_on')
                            ->label('Motor Encendido')
                            ->default(false)
                            ->onColor('success')
                            ->offColor('gray'),
                        Toggle::make('is_working')
                            ->label('En Operación (Trabajando)')
                            ->default(false)
                            ->onColor('success')
                            ->offColor('gray'),
                    ]),

                Section::make('Lecturas e Indicadores')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(2)
                    ->schema([
                        TextInput::make('location')
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
                        TextInput::make('hours_reading')
                            ->label('Lectura del Horómetro')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->helperText('Lectura actual del horómetro'),
                    ]),

                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas')
                            ->rows(2)
                            ->placeholder('Observaciones del estado...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
