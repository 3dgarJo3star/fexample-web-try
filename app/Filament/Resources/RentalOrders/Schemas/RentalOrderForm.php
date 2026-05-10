<?php

declare(strict_types=1);

namespace App\Filament\Resources\RentalOrders\Schemas;

use App\Enums\{PaymentMethod, RentalOrderStatus};
use Filament\Forms\Components\{DatePicker, Select, TextInput, Textarea, TimePicker, Toggle};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RentalOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Datos del Servicio')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('Asignación de grúa, operador y lugar de trabajo')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        Select::make('operator_id')
                            ->label('Operador')
                            ->relationship('operator', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        Select::make('client_id')
                            ->label('Cliente / Empresa')
                            ->relationship('client', 'company_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),
                        TextInput::make('service_location')
                            ->label('Lugar del Servicio')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ej: Av. Reforma 222, CDMX')
                            ->columnSpanFull(),
                        Select::make('zone_id')
                            ->label('Zona')
                            ->relationship('zone', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->native(false),
                        DatePicker::make('start_date')
                            ->label('Fecha del Servicio')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ]),

                Section::make('Tiempos')
                    ->icon('heroicon-o-clock')
                    ->description('Registre los horarios conforme avance el servicio')
                    ->columns(4)
                    ->collapsible()
                    ->schema([
                        TimePicker::make('arrival_time')
                            ->label('Llegada al Sitio')
                            ->seconds(false),
                        TimePicker::make('start_time')
                            ->label('Inicio Operación')
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label('Término Operación')
                            ->seconds(false),
                        TimePicker::make('departure_time')
                            ->label('Retiro')
                            ->seconds(false),
                    ]),

                Section::make('Autorización del Cliente')
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('authorized_by_name')
                            ->label('Nombre de quien Autoriza')
                            ->maxLength(255)
                            ->placeholder('Nombre completo'),
                        TextInput::make('authorized_by_phone')
                            ->label('Teléfono de quien Autoriza')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('Ej: 55 1234 5678'),
                        Toggle::make('client_signature')
                            ->label('Firma de Conformidad Obtenida')
                            ->default(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Marcar cuando el cliente firme de conformidad'),
                    ]),

                Section::make('Estado y Pago')
                    ->icon('heroicon-o-banknotes')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Estado de la Orden')
                            ->options(RentalOrderStatus::class)
                            ->required()
                            ->default(RentalOrderStatus::Pending)
                            ->native(false),
                        Select::make('payment_method')
                            ->label('Método de Pago')
                            ->options(PaymentMethod::class)
                            ->required()
                            ->default(PaymentMethod::Cash)
                            ->native(false),
                    ]),

                Section::make('Notas Internas')
                    ->icon('heroicon-o-lock-closed')
                    ->description('Visible solo para administración')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('internal_notes')
                            ->label('Notas Internas')
                            ->rows(3)
                            ->placeholder('Notas visibles solo para el equipo administrativo...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
