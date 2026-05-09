<?php

namespace App\Filament\Resources\RentalOrders\Schemas;

use App\Enums\PaymentMethod;
use App\Enums\RentalOrderStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RentalOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del Servicio')
                    ->columns(2)
                    ->schema([
                        Select::make('crane_id')
                            ->label('Grúa')
                            ->relationship('crane', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('operator_id')
                            ->label('Operador')
                            ->relationship('operator', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('client_id')
                            ->label('Cliente / Empresa')
                            ->relationship('client', 'company_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('service_location')
                            ->label('Lugar del Servicio')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('zone_id')
                            ->label('Zona')
                            ->relationship('zone', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        DatePicker::make('start_date')
                            ->label('Fecha')
                            ->required(),
                    ]),

                Section::make('Tiempos')
                    ->columns(2)
                    ->schema([
                        TimePicker::make('arrival_time')
                            ->label('Hora de Llegada al Sitio')
                            ->seconds(false),
                        TimePicker::make('start_time')
                            ->label('Hora de Inicio de Operación')
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label('Hora de Término de Operación')
                            ->seconds(false),
                        TimePicker::make('departure_time')
                            ->label('Hora de Retiro')
                            ->seconds(false),
                    ]),

                Section::make('Autorización del Cliente')
                    ->columns(2)
                    ->schema([
                        TextInput::make('authorized_by_name')
                            ->label('Nombre de quien Autoriza')
                            ->maxLength(255),
                        TextInput::make('authorized_by_phone')
                            ->label('Teléfono de quien Autoriza')
                            ->tel()
                            ->maxLength(20),
                        Toggle::make('client_signature')
                            ->label('Firma de Conformidad Obtenida')
                            ->default(false),
                    ]),

                Section::make('Estado y Pago')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Estado de la Orden')
                            ->options(RentalOrderStatus::class)
                            ->required()
                            ->default(RentalOrderStatus::Pending),
                        Select::make('payment_method')
                            ->label('Método de Pago')
                            ->options(PaymentMethod::class)
                            ->required()
                            ->default(PaymentMethod::Cash),
                    ]),

                Section::make('Notas Internas')
                    ->description('Visible solo para administración')
                    ->schema([
                        Textarea::make('internal_notes')
                            ->label('Notas Internas')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
