<?php

namespace App\Filament\Resources\Maintenance\Tables;

use App\Enums\MaintenanceStatus;
use App\Enums\MaintenanceType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaintenanceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('crane.name')->label('Grúa')->searchable()->sortable(),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('hours_at_maintenance')->label('Horas')->suffix(' hrs')->sortable(),
                TextColumn::make('next_maintenance_hours')->label('Próximo a')->suffix(' hrs'),
                TextColumn::make('scheduled_date')->label('Programado')->date('d/m/Y')->placeholder('-'),
                TextColumn::make('completed_date')->label('Completado')->date('d/m/Y')->placeholder('-'),
                TextColumn::make('status')->label('Estado')->badge()->sortable(),
                TextColumn::make('cost')->label('Costo')->money('MXN')->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Estado')->options(MaintenanceStatus::class),
                SelectFilter::make('type')->label('Tipo')->options(MaintenanceType::class),
                SelectFilter::make('crane_id')->label('Grúa')->relationship('crane', 'name'),
            ])
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
