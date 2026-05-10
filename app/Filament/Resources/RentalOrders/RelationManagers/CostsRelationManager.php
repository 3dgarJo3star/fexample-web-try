<?php

declare(strict_types=1);

namespace App\Filament\Resources\RentalOrders\RelationManagers;

use App\Enums\UserRole;
use Filament\Actions\{CreateAction, DeleteAction, EditAction};
use Filament\Forms\Components\{TextInput, Textarea};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CostsRelationManager extends RelationManager
{
    protected static string $relationship = 'costs';

    protected static ?string $title = 'Costos (Uso Interno)';

    public static function canViewForRecord(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): bool
    {
        return in_array(auth()->user()?->role, [UserRole::Admin, UserRole::Administrative]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('description')
                ->label('Descripción')
                ->required()
                ->maxLength(255)
                ->placeholder('Ej: Combustible, Peaje, Viáticos'),
            TextInput::make('amount')
                ->label('Monto')
                ->numeric()
                ->prefix('$')
                ->required()
                ->placeholder('0.00'),
            Textarea::make('notes')
                ->label('Notas')
                ->rows(2)
                ->placeholder('Notas adicionales del costo...'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable()
                    ->summarize(Sum::make()->money('MXN')->label('Total')),
                TextColumn::make('notes')
                    ->label('Notas')
                    ->placeholder('-')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->notes)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()->label('Agregar Costo'),
            ])
            ->striped();
    }
}
