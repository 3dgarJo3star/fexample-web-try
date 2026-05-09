<?php

namespace App\Filament\Resources\ActivityLog\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ActivityLogTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->label('Módulo')
                    ->badge()
                    ->sortable(),
                TextColumn::make('event')
                    ->label('Acción')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'created' => 'Creado',
                        'updated' => 'Modificado',
                        'deleted' => 'Eliminado',
                        default => $state,
                    }),
                TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('causer.name')
                    ->label('Realizado por')
                    ->placeholder('Sistema')
                    ->searchable(),
                TextColumn::make('properties')
                    ->label('Campos Modificados')
                    ->state(function ($record) {
                        $props = $record->properties;
                        if (!$props || !isset($props['old'])) {
                            return '-';
                        }
                        $old = $props['old'] ?? [];
                        $new = $props['attributes'] ?? [];
                        $changed = array_keys(array_diff_assoc($new, $old));
                        return implode(', ', $changed);
                    })
                    ->wrap()
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('log_name')
                    ->label('Módulo')
                    ->options([
                        'grúas' => 'Grúas',
                        'órdenes' => 'Órdenes',
                        'mantenimiento' => 'Mantenimiento',
                        'clientes' => 'Clientes',
                    ]),
                SelectFilter::make('event')
                    ->label('Acción')
                    ->options([
                        'created' => 'Creado',
                        'updated' => 'Modificado',
                        'deleted' => 'Eliminado',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }
}
