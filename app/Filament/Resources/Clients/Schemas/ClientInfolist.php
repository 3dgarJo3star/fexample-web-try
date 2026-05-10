<?php

declare(strict_types=1);

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos de la Empresa')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('company_name')
                            ->label('Empresa')
                            ->weight(FontWeight::Bold)
                            ->columnSpanFull(),
                        TextEntry::make('contact_name')->label('Persona que Autoriza')->icon('heroicon-o-user'),
                        TextEntry::make('phone')->label('Teléfono')->icon('heroicon-o-phone')->copyable(),
                        TextEntry::make('email')->label('Correo')->placeholder('-')->icon('heroicon-o-envelope')->copyable(),
                        TextEntry::make('rfc')->label('RFC')->placeholder('-')->copyable(),
                        TextEntry::make('address')->label('Dirección')->placeholder('-')->icon('heroicon-o-map-pin')->columnSpanFull(),
                    ]),
                Section::make('Notas')
                    ->icon('heroicon-o-pencil-square')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('notes')->label('Notas')->placeholder('Sin notas registradas')->columnSpanFull(),
                    ]),
            ]);
    }
}
