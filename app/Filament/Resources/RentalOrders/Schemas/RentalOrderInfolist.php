<?php

namespace App\Filament\Resources\RentalOrders\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RentalOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de la Orden')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('order_number')->label('No. Orden'),
                        TextEntry::make('status')->label('Estado')->badge(),
                        TextEntry::make('start_date')->label('Fecha')->date('d/m/Y'),
                    ]),

                Section::make('Datos del Servicio')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('crane.name')->label('Grúa'),
                        TextEntry::make('operator.name')->label('Operador'),
                        TextEntry::make('client.company_name')->label('Empresa Cliente')->columnSpanFull(),
                        TextEntry::make('service_location')->label('Lugar del Servicio')->columnSpanFull(),
                        TextEntry::make('zone.name')->label('Zona')->placeholder('Sin zona'),
                    ]),

                Section::make('Tiempos')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('arrival_time')->label('Llegada al Sitio')->placeholder('-'),
                        TextEntry::make('start_time')->label('Inicio Operación')->placeholder('-'),
                        TextEntry::make('end_time')->label('Término Operación')->placeholder('-'),
                        TextEntry::make('departure_time')->label('Retiro')->placeholder('-'),
                    ]),

                Section::make('Autorización')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('authorized_by_name')->label('Autorizó')->placeholder('-'),
                        TextEntry::make('authorized_by_phone')->label('Teléfono Autorización')->placeholder('-'),
                        IconEntry::make('client_signature')->label('Firma de Conformidad')->boolean(),
                        TextEntry::make('payment_method')->label('Método de Pago')->badge(),
                    ]),

                Section::make('Notas Internas')
                    ->visible(fn () => in_array(auth()->user()?->role, [UserRole::Admin, UserRole::Administrative]))
                    ->schema([
                        TextEntry::make('internal_notes')->label('Notas Internas')->placeholder('Sin notas')->columnSpanFull(),
                    ]),
            ]);
    }
}
