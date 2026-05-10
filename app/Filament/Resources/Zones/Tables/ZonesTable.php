<?php

declare(strict_types=1);

namespace App\Filament\Resources\Zones\Tables;

use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction};
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ZonesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Zona')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->placeholder('-')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),
                TextColumn::make('rental_orders_count')
                    ->label('Órdenes')
                    ->counts('rentalOrders')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                IconColumn::make('is_active')->label('Activa')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas')
                    ->placeholder('Todas'),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('name')
            ->striped();
    }
}
