<?php

namespace App\Filament\Resources\Cranes\Tables;

use App\Enums\CraneStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->sortable(),
                TextColumn::make('brand')
                    ->label('Marca')
                    ->searchable(),
                TextColumn::make('capacity_tons')
                    ->label('Capacidad')
                    ->suffix(' ton')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->sortable(),
                TextColumn::make('current_location')
                    ->label('Ubicación')
                    ->searchable()
                    ->placeholder('Sin registrar'),
                TextColumn::make('diesel_level')
                    ->label('Diesel')
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('total_hours')
                    ->label('Horas Totales')
                    ->suffix(' hrs')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activa')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(CraneStatus::class),
                SelectFilter::make('is_active')
                    ->label('Activa')
                    ->options([
                        '1' => 'Sí',
                        '0' => 'No',
                    ]),
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
            ->defaultSort('name');
    }
}
