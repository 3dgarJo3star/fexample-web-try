<?php

namespace App\Filament\Resources\Maintenance\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MaintenanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mantenimiento')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('crane.name')->label('Grúa'),
                        TextEntry::make('type')->label('Tipo')->badge(),
                        TextEntry::make('status')->label('Estado')->badge(),
                        TextEntry::make('hours_at_maintenance')->label('Horas Realizadas')->suffix(' hrs'),
                        TextEntry::make('next_maintenance_hours')->label('Próximo a las Horas')->suffix(' hrs'),
                        TextEntry::make('cost')->label('Costo')->money('MXN')->placeholder('No registrado'),
                        TextEntry::make('scheduled_date')->label('Fecha Programada')->date('d/m/Y')->placeholder('-'),
                        TextEntry::make('completed_date')->label('Fecha Realizado')->date('d/m/Y')->placeholder('-'),
                        TextEntry::make('description')->label('Descripción')->columnSpanFull(),
                    ]),
            ]);
    }
}
