<?php

declare(strict_types=1);

namespace App\Filament\Resources\RentalOrders\Schemas;

use App\Enums\UserRole;
use Filament\Infolists\Components\{IconEntry, TextEntry};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class RentalOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Información de la Orden')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('No. Orden')
                            ->weight(FontWeight::Bold)
                            ->copyable(),
                        TextEntry::make('status')->label('Estado')->badge(),
                        TextEntry::make('start_date')->label('Fecha')->date('d/m/Y')->icon('heroicon-o-calendar'),
                    ]),

                Section::make('Datos del Servicio')
                    ->icon('heroicon-o-truck')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('crane.name')->label('Grúa')->icon('heroicon-o-wrench-screwdriver'),
                        TextEntry::make('operator.name')->label('Operador')->icon('heroicon-o-user'),
                        TextEntry::make('client.company_name')
                            ->label('Empresa Cliente')
                            ->icon('heroicon-o-building-office-2')
                            ->weight(FontWeight::SemiBold)
                            ->columnSpanFull(),
                        TextEntry::make('service_location')
                            ->label('Lugar del Servicio')
                            ->icon('heroicon-o-map')
                            ->columnSpanFull(),
                        TextEntry::make('zone.name')->label('Zona')->placeholder('Sin zona')->icon('heroicon-o-map-pin'),
                    ]),

                Section::make('Tiempos')
                    ->icon('heroicon-o-clock')
                    ->columns(4)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('arrival_time')->label('Llegada al Sitio')->placeholder('-')->icon('heroicon-o-arrow-down-on-square'),
                        TextEntry::make('start_time')->label('Inicio Operación')->placeholder('-')->icon('heroicon-o-play'),
                        TextEntry::make('end_time')->label('Término Operación')->placeholder('-')->icon('heroicon-o-stop'),
                        TextEntry::make('departure_time')->label('Retiro')->placeholder('-')->icon('heroicon-o-arrow-up-on-square'),
                    ]),

                Section::make('Autorización')
                    ->icon('heroicon-o-shield-check')
                    ->columns(3)
                    ->collapsible()
                    ->schema([
                        TextEntry::make('authorized_by_name')->label('Autorizó')->placeholder('-'),
                        TextEntry::make('authorized_by_phone')->label('Teléfono Autorización')->placeholder('-'),
                        IconEntry::make('client_signature')->label('Firma de Conformidad')->boolean(),
                        TextEntry::make('payment_method')->label('Método de Pago')->badge(),
                    ]),

                Section::make('Notas Internas')
                    ->icon('heroicon-o-lock-closed')
                    ->visible(fn () => in_array(auth()->user()?->role, [UserRole::Admin, UserRole::Administrative]))
                    ->collapsible()
                    ->schema([
                        TextEntry::make('internal_notes')->label('Notas Internas')->placeholder('Sin notas')->columnSpanFull(),
                    ]),
            ]);
    }
}
