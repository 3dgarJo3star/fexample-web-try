<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\{BulkActionGroup, DeleteBulkAction, EditAction, ViewAction};
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Empresa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('contact_name')
                    ->label('Persona que Autoriza')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->copyable(),
                TextColumn::make('email')
                    ->label('Correo')
                    ->searchable()
                    ->placeholder('-')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('rfc')
                    ->label('RFC')
                    ->placeholder('-')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('rental_orders_count')
                    ->label('Órdenes')
                    ->counts('rentalOrders')
                    ->sortable()
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                Filter::make('has_orders')
                    ->label('Con órdenes')
                    ->query(fn (Builder $query) => $query->has('rentalOrders')),
                Filter::make('no_orders')
                    ->label('Sin órdenes')
                    ->query(fn (Builder $query) => $query->doesntHave('rentalOrders')),
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
            ->defaultSort('company_name')
            ->striped();
    }
}
