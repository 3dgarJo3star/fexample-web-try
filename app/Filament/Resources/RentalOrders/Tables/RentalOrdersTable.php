<?php

declare(strict_types=1);

namespace App\Filament\Resources\RentalOrders\Tables;

use App\Enums\RentalOrderStatus;
use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction, ViewAction};
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\{Filter, SelectFilter};
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RentalOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Orden')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('crane.name')
                    ->label('Grúa')
                    ->searchable()
                    ->icon('heroicon-o-wrench-screwdriver'),
                TextColumn::make('operator.name')
                    ->label('Operador')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('client.company_name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('service_location')
                    ->label('Lugar')
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->service_location)
                    ->toggleable(),
                TextColumn::make('start_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),
                IconColumn::make('client_signature')
                    ->label('Firmada')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(RentalOrderStatus::class)
                    ->multiple(),
                SelectFilter::make('crane_id')
                    ->label('Grúa')
                    ->relationship('crane', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'company_name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('operator_id')
                    ->label('Operador')
                    ->relationship('operator', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('zone_id')
                    ->label('Zona')
                    ->relationship('zone', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('start_date')
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
                            ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('start_date', '>=', $date))
                            ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('start_date', '<=', $date));
                    })
                    ->columns(2),
            ])
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc')
            ->striped();
    }
}
