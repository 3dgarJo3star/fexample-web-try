<?php

declare(strict_types=1);

namespace App\Filament\Client\Resources;

use App\Filament\Client\Resources\ClientRentalOrder\Pages\{ListClientOrders, ViewClientOrder};
use App\Models\RentalOrder;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\{IconEntry, TextEntry};
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\{FontWeight, IconPosition, TextSize};
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientRentalOrderResource extends Resource
{
    protected static ?string $model = RentalOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Mis Órdenes';

    protected static ?string $modelLabel = 'Orden';

    protected static ?string $pluralModelLabel = 'Mis Órdenes';

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->forClient(auth()->user()?->client_id)
            ->with(['crane', 'operator', 'zone']);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detalle de la Orden')
                ->icon('heroicon-o-clipboard-document-list')
                ->columns(3)
                ->schema([
                    TextEntry::make('order_number')
                        ->label('No. Orden')
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large)
                        ->copyable(),
                    TextEntry::make('status')->label('Estado')->badge(),
                    TextEntry::make('start_date')->label('Fecha')->date('d/m/Y')->icon('heroicon-o-calendar'),
                    TextEntry::make('crane.name')->label('Grúa')->icon('heroicon-o-wrench-screwdriver'),
                    TextEntry::make('operator.name')->label('Operador')->icon('heroicon-o-user'),
                    TextEntry::make('zone.name')->label('Zona')->placeholder('Sin zona')->icon('heroicon-o-map-pin'),
                    TextEntry::make('service_location')
                        ->label('Lugar del Servicio')
                        ->icon('heroicon-o-map')
                        ->columnSpanFull(),
                ]),
            Section::make('Tiempos')
                ->icon('heroicon-o-clock')
                ->columns(4)
                ->collapsible()
                ->schema([
                    TextEntry::make('arrival_time')->label('Llegada')->placeholder('-')->icon('heroicon-o-arrow-down-on-square'),
                    TextEntry::make('start_time')->label('Inicio')->placeholder('-')->icon('heroicon-o-play'),
                    TextEntry::make('end_time')->label('Término')->placeholder('-')->icon('heroicon-o-stop'),
                    TextEntry::make('departure_time')->label('Retiro')->placeholder('-')->icon('heroicon-o-arrow-up-on-square'),
                ]),
            Section::make('Autorización')
                ->icon('heroicon-o-shield-check')
                ->columns(2)
                ->collapsible()
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
                TextColumn::make('order_number')
                    ->label('No. Orden')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('crane.name')
                    ->label('Grúa')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->iconPosition(IconPosition::Before),
                TextColumn::make('service_location')->label('Lugar')->limit(30)->tooltip(fn ($record) => $record->service_location),
                TextColumn::make('start_date')->label('Fecha')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Estado')->badge()->sortable(),
                IconColumn::make('client_signature')->label('Firmada')->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options(\App\Enums\RentalOrderStatus::class),
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
