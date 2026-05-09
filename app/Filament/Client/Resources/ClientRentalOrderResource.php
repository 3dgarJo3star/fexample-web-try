<?php

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\ClientRentalOrder\Pages\ListClientOrders;
use App\Filament\Client\Resources\ClientRentalOrder\Pages\ViewClientOrder;
use App\Models\RentalOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Actions\ViewAction;

class ClientRentalOrderResource extends Resource
{
    protected static ?string $model = RentalOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Mis Órdenes';

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Mis Órdenes';

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user?->client_id) {
            $query->where('client_id', $user->client_id);
        } else {
            $query->whereRaw('1 = 0');
        }

        return $query;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detalle de la Orden')
                ->columns(3)
                ->schema([
                    TextEntry::make('order_number')->label('No. Orden'),
                    TextEntry::make('status')->label('Estado')->badge(),
                    TextEntry::make('start_date')->label('Fecha')->date('d/m/Y'),
                    TextEntry::make('crane.name')->label('Grúa'),
                    TextEntry::make('operator.name')->label('Operador'),
                    TextEntry::make('zone.name')->label('Zona')->placeholder('Sin zona'),
                    TextEntry::make('service_location')->label('Lugar del Servicio')->columnSpanFull(),
                ]),
            Section::make('Tiempos')
                ->columns(4)
                ->schema([
                    TextEntry::make('arrival_time')->label('Llegada')->placeholder('-'),
                    TextEntry::make('start_time')->label('Inicio')->placeholder('-'),
                    TextEntry::make('end_time')->label('Término')->placeholder('-'),
                    TextEntry::make('departure_time')->label('Retiro')->placeholder('-'),
                ]),
            Section::make('Autorización')
                ->columns(2)
                ->schema([
                    TextEntry::make('authorized_by_name')->label('Autorizó')->placeholder('-'),
                    TextEntry::make('authorized_by_phone')->label('Teléfono')->placeholder('-'),
                    IconEntry::make('client_signature')->label('Firma de Conformidad')->boolean(),
                    TextEntry::make('payment_method')->label('Método de Pago')->badge(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->label('No. Orden')->searchable()->sortable(),
                TextColumn::make('crane.name')->label('Grúa'),
                TextColumn::make('service_location')->label('Lugar')->limit(30),
                TextColumn::make('start_date')->label('Fecha')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Estado')->badge()->sortable(),
                IconColumn::make('client_signature')->label('Firmada')->boolean(),
            ])
            ->recordActions([ViewAction::make()])
            ->defaultSort('start_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientOrders::route('/'),
            'view' => ViewClientOrder::route('/{record}'),
        ];
    }
}
