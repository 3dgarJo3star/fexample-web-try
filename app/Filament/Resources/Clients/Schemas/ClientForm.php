<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\{TextInput, Textarea};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos de la Empresa')
                    ->icon('heroicon-o-building-office-2')
                    ->description('Información fiscal y de contacto del cliente')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nombre de la Empresa')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: Constructora ABC S.A. de C.V.')
                            ->columnSpanFull(),
                        TextInput::make('contact_name')
                            ->label('Persona que Autoriza')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nombre completo'),
                        TextInput::make('phone')
                            ->label('Teléfono de Autorización')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->placeholder('Ej: 55 1234 5678'),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(255)
                            ->placeholder('correo@empresa.com'),
                        TextInput::make('rfc')
                            ->label('RFC')
                            ->maxLength(13)
                            ->dehydrateStateUsing(fn (?string $state): ?string => $state ? mb_strtoupper($state) : null)
                            ->placeholder('XAXX010101000')
                            ->helperText('13 caracteres para personas morales'),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(500)
                            ->placeholder('Calle, número, colonia, ciudad, CP')
                            ->columnSpanFull(),
                    ]),
                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notas Internas')
                            ->rows(3)
                            ->placeholder('Observaciones internas sobre el cliente...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
