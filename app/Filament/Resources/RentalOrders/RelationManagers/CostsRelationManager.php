<?php

namespace App\Filament\Resources\RentalOrders\RelationManagers;

use App\Enums\UserRole;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
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
                ->maxLength(255),
            TextInput::make('amount')
                ->label('Monto')
                ->numeric()
                ->prefix('$')
                ->required(),
            Textarea::make('notes')
                ->label('Notas')
                ->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')->label('Descripción'),
                TextColumn::make('amount')
                    ->label('Monto')
                    ->money('MXN')
                    ->sortable(),
                TextColumn::make('notes')->label('Notas')->placeholder('-')->limit(40),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()->label('Agregar Costo'),
            ]);
    }
}
