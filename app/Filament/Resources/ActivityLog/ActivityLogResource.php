<?php

namespace App\Filament\Resources\ActivityLog;

use App\Filament\Resources\ActivityLog\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLog\Tables\ActivityLogTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function getNavigationGroup(): string|null
    {
        return 'Configuración';
    }

    protected static ?string $navigationLabel = 'Historial de Cambios';

    protected static ?string $modelLabel = 'Registro';

    protected static ?string $pluralModelLabel = 'Historial de Cambios';

    protected static ?int $navigationSort = 10;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return ActivityLogTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
        ];
    }
}
