<?php

namespace App\Filament\Resources\Maintenance;

use App\Filament\Resources\Maintenance\Pages\CreateMaintenanceRecord;
use App\Filament\Resources\Maintenance\Pages\EditMaintenanceRecord;
use App\Filament\Resources\Maintenance\Pages\ListMaintenanceRecords;
use App\Filament\Resources\Maintenance\Pages\ViewMaintenanceRecord;
use App\Filament\Resources\Maintenance\Schemas\MaintenanceForm;
use App\Filament\Resources\Maintenance\Schemas\MaintenanceInfolist;
use App\Filament\Resources\Maintenance\Tables\MaintenanceTable;
use App\Models\MaintenanceRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MaintenanceResource extends Resource
{
    protected static ?string $model = MaintenanceRecord::class;

    public static function getNavigationGroup(): string|null
    {
        return 'Flota';
    }


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrench;


    protected static ?string $navigationLabel = 'Mantenimientos';

    protected static ?string $modelLabel = 'Mantenimiento';

    protected static ?string $pluralModelLabel = 'Mantenimientos';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MaintenanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaintenanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceRecords::route('/'),
            'create' => CreateMaintenanceRecord::route('/create'),
            'view' => ViewMaintenanceRecord::route('/{record}'),
            'edit' => EditMaintenanceRecord::route('/{record}/edit'),
        ];
    }
}
