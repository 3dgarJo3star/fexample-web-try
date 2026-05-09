<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos de la Empresa')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('company_name')->label('Empresa')->columnSpanFull(),
                        TextEntry::make('contact_name')->label('Persona que Autoriza'),
                        TextEntry::make('phone')->label('Teléfono'),
                        TextEntry::make('email')->label('Correo')->placeholder('-'),
                        TextEntry::make('rfc')->label('RFC')->placeholder('-'),
                        TextEntry::make('address')->label('Dirección')->placeholder('-')->columnSpanFull(),
                    ]),
                Section::make('Notas')
                    ->schema([
                        TextEntry::make('notes')->label('Notas')->placeholder('-')->columnSpanFull(),
                    ]),
            ]);
    }
}
