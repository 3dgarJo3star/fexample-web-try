<?php

declare(strict_types=1);

namespace App\Filament\Resources\CraneStatus\Tables;

use Filament\Actions\{BulkActionGroup, DeleteBulkAction, ViewAction};
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\{Filter, SelectFilter, TernaryFilter};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CraneStatusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('crane.name')
                    ->label('Grúa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('operator.name')
                    ->label('Operador')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('logged_at')
                    ->label('Fecha/Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                IconColumn::make('is_on')->label('Motor')->boolean(),
                IconColumn::make('is_working')->label('Trabajando')->boolean(),
                TextColumn::make('location')
                    ->label('Ubicación')
                    ->placeholder('-')
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->location)
                    ->toggleable(),
                TextColumn::make('diesel_level')
                    ->label('Diesel')
                    ->suffix('%')
                    ->color(fn ($state): string => match (true) {
                        $state === null => 'gray',
                        $state <= 20 => 'danger',
                        $state <= 50 => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('hours_reading')
                    ->label('Horómetro')
                    ->suffix(' hrs')
                    ->placeholder('-')
                    ->numeric(decimalPlaces: 0),
            ])
            ->filters([
                SelectFilter::make('crane_id')
                    ->label('Grúa')
                    ->relationship('crane', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('operator_id')
                    ->label('Operador')
                    ->relationship('operator', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_working')
                    ->label('Trabajando')
                    ->trueLabel('En operación')
                    ->falseLabel('Detenida')
                    ->placeholder('Todas'),
                Filter::make('logged_at')
                    ->label('Rango de Fechas')
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
                            ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('logged_at', '>=', $date))
                            ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('logged_at', '<=', $date));
                    })
                    ->columns(2),
            ])
            ->filtersFormColumns(2)
            ->recordActions([ViewAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('logged_at', 'desc')
            ->striped();
    }
}
