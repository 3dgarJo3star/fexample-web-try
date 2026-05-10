<?php

declare(strict_types=1);

namespace App\Filament\Resources\Maintenance\Schemas;

use App\Enums\{MaintenanceStatus, MaintenanceType};
use Filament\Forms\Components\{DatePicker, Select, TextInput, Textarea};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaintenanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Grúa y Tipo')
                    ->icon('heroicon-o-wrench')
                    ->description('Seleccione la grúa y el tipo de mantenimiento')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        Select::make('type')
                            ->label('Tipo')
                            ->options(MaintenanceType::class)
                            ->required()
                            ->default(MaintenanceType::Preventive)
                            ->native(false),
                    ]),

                Section::make('Horómetro')
                    ->icon('heroicon-o-clock')
                    ->description('Lecturas de horas para control de mantenimiento')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hours_at_maintenance')
                            ->label('Horas al Momento del Mantenimiento')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->required()
                            ->helperText('Lectura del horómetro al realizar el servicio'),
                        TextInput::make('next_maintenance_hours')
                            ->label('Próximo Mantenimiento a las Horas')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->required()
                            ->default(fn ($get) => $get('hours_at_maintenance') ? (float) $get('hours_at_maintenance') + 400 : null)
                            ->helperText('Se calcula automáticamente (+400 hrs)'),
                    ]),

                Section::make('Programación y Costo')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('scheduled_date')
                            ->label('Fecha Programada')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('completed_date')
                            ->label('Fecha de Realización')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Select::make('status')
                            ->label('Estado')
                            ->options(MaintenanceStatus::class)
                            ->required()
                            ->default(MaintenanceStatus::Pending)
                            ->native(false),
                        TextInput::make('cost')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->placeholder('0.00'),
                    ]),

                Section::make('Descripción del Trabajo')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('description')
                            ->label('Descripción del Trabajo')
                            ->required()
                            ->rows(3)
                            ->placeholder('Detalle del trabajo realizado o a realizar...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
