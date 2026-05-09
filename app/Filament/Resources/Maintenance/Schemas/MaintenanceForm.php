<?php

namespace App\Filament\Resources\Maintenance\Schemas;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MaintenanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Mantenimiento')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('type')
                            ->label('Tipo')
                            ->options(MaintenanceType::class)
                            ->required()
                            ->default(MaintenanceType::Preventive),
                        TextInput::make('hours_at_maintenance')
                            ->label('Horas al Momento del Mantenimiento')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->required(),
                        TextInput::make('next_maintenance_hours')
                            ->label('Próximo Mantenimiento a las Horas')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('hrs')
                            ->required()
                            ->default(fn ($get) => $get('hours_at_maintenance') ? (float) $get('hours_at_maintenance') + 400 : null),
                        DatePicker::make('scheduled_date')
                            ->label('Fecha Programada'),
                        DatePicker::make('completed_date')
                            ->label('Fecha de Realización'),
                        Select::make('status')
                            ->label('Estado')
                            ->options(MaintenanceStatus::class)
                            ->required()
                            ->default(MaintenanceStatus::Pending),
                        TextInput::make('cost')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),
                        Textarea::make('description')
                            ->label('Descripción del Trabajo')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
