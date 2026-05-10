<?php

declare(strict_types=1);

namespace App\Filament\Resources\CraneStatus;

use App\Filament\Resources\CraneStatus\Pages\{CreateCraneStatusLog, ListCraneStatusLogs, ViewCraneStatusLog};
use App\Filament\Resources\CraneStatus\Schemas\{CraneStatusForm, CraneStatusInfolist};
use App\Filament\Resources\CraneStatus\Tables\CraneStatusTable;
use App\Models\CraneStatusLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CraneStatusResource extends Resource
{
    protected static ?string $model = CraneStatusLog::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['crane', 'operator']);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Flota';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSignal;

    protected static ?string $navigationLabel = 'Bitácora de Estado';

    protected static ?string $modelLabel = 'Registro de Estado';

    protected static ?string $pluralModelLabel = 'Bitácora de Estado';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'location';

    public static function form(Schema $schema): Schema
    {
        return CraneStatusForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CraneStatusInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CraneStatusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCraneStatusLogs::route('/'),
            'create' => CreateCraneStatusLog::route('/create'),
            'view' => ViewCraneStatusLog::route('/{record}'),
        ];
    }
}
