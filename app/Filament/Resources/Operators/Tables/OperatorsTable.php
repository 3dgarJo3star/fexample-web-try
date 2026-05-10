<?php

declare(strict_types=1);

namespace App\Filament\Resources\Operators\Tables;

use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction, ViewAction};
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OperatorsTable
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
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('license_number')
                    ->label('Licencia')
                    ->searchable()
                    ->placeholder('-')
                    ->copyable(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->placeholder('Sin usuario')
                    ->icon('heroicon-o-computer-desktop')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Estado')
                    ->trueLabel('Solo activos')
                    ->falseLabel('Solo inactivos')
                    ->placeholder('Todos'),
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
