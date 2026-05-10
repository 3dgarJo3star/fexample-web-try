<?php

declare(strict_types=1);

namespace App\Filament\Resources\Operators\Schemas;

use Filament\Forms\Components\{Select, TextInput, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OperatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos del Operador')
                    ->icon('heroicon-o-user')
                    ->description('Información personal y de contacto')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nombre completo del operador')
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('Ej: 55 1234 5678'),
                        TextInput::make('license_number')
                            ->label('No. Licencia')
                            ->maxLength(50)
                            ->placeholder('Número de licencia vigente'),
                    ]),
                Section::make('Acceso al Sistema')
                    ->icon('heroicon-o-computer-desktop')
                    ->description('Vincular con una cuenta de usuario para acceso al sistema')
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('Usuario del Sistema')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->native(false)
                            ->helperText('Opcional: vincular con un usuario existente'),
                        Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),
            ]);
    }
}
