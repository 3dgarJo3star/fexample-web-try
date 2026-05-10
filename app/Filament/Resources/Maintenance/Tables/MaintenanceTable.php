<?php

declare(strict_types=1);

namespace App\Filament\Resources\Maintenance\Tables;

use App\Enums\{MaintenanceStatus, MaintenanceType};
use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction, ViewAction};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\{Filter, SelectFilter};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('crane.name')
                    ->label('Grúa')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-wrench-screwdriver'),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('hours_at_maintenance')
                    ->label('Horas')
                    ->suffix(' hrs')
                    ->sortable()
                    ->numeric(decimalPlaces: 0),
                TextColumn::make('next_maintenance_hours')
                    ->label('Próximo a')
                    ->suffix(' hrs')
                    ->numeric(decimalPlaces: 0)
                    ->toggleable(),
                TextColumn::make('scheduled_date')
                    ->label('Programado')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('completed_date')
                    ->label('Completado')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')->label('Estado')->badge()->sortable(),
                TextColumn::make('cost')
                    ->label('Costo')
                    ->money('MXN')
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(MaintenanceStatus::class),
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options(MaintenanceType::class),
                SelectFilter::make('crane_id')
                    ->label('Grúa')
                    ->relationship('crane', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('scheduled_date')
                    ->label('Rango Programado')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('Desde')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        \Filament\Forms\Components\DatePicker::make('until')
                            ->label('Hasta')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('scheduled_date', '>=', $date))
                            ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('scheduled_date', '<=', $date));
                    })
                    ->columns(2),
            ])
            ->filtersFormColumns(2)
            ->recordActions([ViewAction::make(), EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
