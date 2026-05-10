<?php

declare(strict_types=1);

namespace App\Filament\Resources\Operators\Schemas;

use Filament\Infolists\Components\{IconEntry, TextEntry};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class OperatorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos del Operador')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre')
                            ->weight(FontWeight::Bold)
                            ->columnSpanFull(),
                        TextEntry::make('phone')
                            ->label('Teléfono')
                            ->placeholder('-')
                            ->icon('heroicon-o-phone')
                            ->copyable(),
                        TextEntry::make('license_number')
                            ->label('No. Licencia')
                            ->placeholder('-')
                            ->copyable(),
                    ]),
                Section::make('Acceso al Sistema')
                    ->icon('heroicon-o-computer-desktop')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Usuario del Sistema')
                            ->placeholder('Sin usuario vinculado'),
                        IconEntry::make('is_active')->label('Activo')->boolean(),
                    ]),
            ]);
    }
}
