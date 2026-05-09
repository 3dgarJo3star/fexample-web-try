<?php

namespace App\Filament\Resources\RentalOrders\Tables;

use App\Enums\RentalOrderStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RentalOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Orden')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('crane.name')
                    ->label('Grúa')
                    ->searchable(),
                TextColumn::make('operator.name')
                    ->label('Operador')
                    ->searchable(),
                TextColumn::make('client.company_name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('service_location')
                    ->label('Lugar')
                    ->limit(30),
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
                    ->options(RentalOrderStatus::class),
                SelectFilter::make('crane_id')
                    ->label('Grúa')
                    ->relationship('crane', 'name'),
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
            ->defaultSort('start_date', 'desc');
    }
}
