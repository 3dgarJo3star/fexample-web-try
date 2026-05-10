<?php

declare(strict_types=1);

namespace App\Filament\Resources\Cranes\Tables;

use App\Enums\CraneStatus;
use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction, ViewAction};
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\{SelectFilter, TernaryFilter};
use Filament\Tables\Table;

class CranesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('brand')
                    ->label('Marca')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('capacity_tons')
                    ->label('Capacidad')
                    ->suffix(' ton')
                    ->sortable()
                    ->numeric(decimalPlaces: 1),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),
                TextColumn::make('current_location')
                    ->label('Ubicación')
                    ->searchable()
                    ->placeholder('Sin registrar')
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->current_location),
                TextColumn::make('diesel_level')
                    ->label('Diesel')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn ($state): string => match (true) {
                        $state <= 20 => 'danger',
                        $state <= 50 => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('total_hours')
                    ->label('Horas')
                    ->suffix(' hrs')
                    ->sortable()
                    ->numeric(decimalPlaces: 0)
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(CraneStatus::class)
                    ->multiple(),
                TernaryFilter::make('is_active')
                    ->label('Activa')
                    ->trueLabel('Solo activas')
                    ->falseLabel('Solo inactivas')
                    ->placeholder('Todas'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name')
            ->striped();
    }
}
