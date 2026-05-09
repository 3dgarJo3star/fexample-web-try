<?php

namespace App\Filament\Resources\CraneStatus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CraneStatusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('crane.name')->label('Grúa')->searchable()->sortable(),
                TextColumn::make('operator.name')->label('Operador')->placeholder('-'),
                TextColumn::make('logged_at')->label('Fecha/Hora')->dateTime('d/m/Y H:i')->sortable(),
                IconColumn::make('is_on')->label('Motor')->boolean(),
                IconColumn::make('is_working')->label('Trabajando')->boolean(),
                TextColumn::make('location')->label('Ubicación')->placeholder('-')->limit(30),
                TextColumn::make('diesel_level')->label('Diesel')->suffix('%'),
                TextColumn::make('hours_reading')->label('Horómetro')->suffix(' hrs')->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('crane_id')->label('Grúa')->relationship('crane', 'name'),
            ])
            ->recordActions([ViewAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ])
            ->defaultSort('logged_at', 'desc');
    }
}
