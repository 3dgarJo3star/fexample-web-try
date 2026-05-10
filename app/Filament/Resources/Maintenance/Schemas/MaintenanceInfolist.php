<?php

declare(strict_types=1);

namespace App\Filament\Resources\Maintenance\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class MaintenanceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Grúa y Tipo')
                    ->icon('heroicon-o-wrench')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('crane.name')
                            ->label('Grúa')
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-o-wrench-screwdriver'),
                        TextEntry::make('type')->label('Tipo')->badge(),
                        TextEntry::make('status')->label('Estado')->badge(),
                    ]),

                Section::make('Horómetro y Costo')
                    ->icon('heroicon-o-clock')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('hours_at_maintenance')->label('Horas Realizadas')->suffix(' hrs'),
                        TextEntry::make('next_maintenance_hours')->label('Próximo a las Horas')->suffix(' hrs'),
                        TextEntry::make('cost')->label('Costo')->money('MXN')->placeholder('No registrado'),
                    ]),

                Section::make('Programación')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('scheduled_date')
                            ->label('Fecha Programada')
                            ->date('d/m/Y')
                            ->placeholder('-')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('completed_date')
                            ->label('Fecha Realizado')
                            ->date('d/m/Y')
                            ->placeholder('-')
                            ->icon('heroicon-o-check-circle'),
                    ]),

                Section::make('Descripción del Trabajo')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('description')->label('Descripción')->columnSpanFull(),
                    ]),
            ]);
    }
}
