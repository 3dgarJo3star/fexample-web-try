<?php

declare(strict_types=1);

namespace App\Filament\Resources\RentalOrders;

use App\Filament\Resources\RentalOrders\Pages\{CreateRentalOrder, EditRentalOrder, ListRentalOrders, ViewRentalOrder};
use App\Filament\Resources\RentalOrders\RelationManagers\CostsRelationManager;
use App\Filament\Resources\RentalOrders\Schemas\{RentalOrderForm, RentalOrderInfolist};
use App\Filament\Resources\RentalOrders\Tables\RentalOrdersTable;
use App\Models\RentalOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RentalOrderResource extends Resource
{
    protected static ?string $model = RentalOrder::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['crane', 'operator', 'client', 'zone']);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operaciones';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Órdenes de Renta';

    protected static ?string $modelLabel = 'Orden de Renta';

    protected static ?string $pluralModelLabel = 'Órdenes de Renta';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function form(Schema $schema): Schema
    {
        return RentalOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RentalOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RentalOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRentalOrders::route('/'),
            'create' => CreateRentalOrder::route('/create'),
            'view' => ViewRentalOrder::route('/{record}'),
            'edit' => EditRentalOrder::route('/{record}/edit'),
        ];
    }
}
