<?php

namespace App\Filament\Resources\CraneStatus;

use App\Filament\Resources\CraneStatus\Pages\CreateCraneStatusLog;
use App\Filament\Resources\CraneStatus\Pages\ListCraneStatusLogs;
use App\Filament\Resources\CraneStatus\Pages\ViewCraneStatusLog;
use App\Filament\Resources\CraneStatus\Schemas\CraneStatusForm;
use App\Filament\Resources\CraneStatus\Schemas\CraneStatusInfolist;
use App\Filament\Resources\CraneStatus\Tables\CraneStatusTable;
use App\Models\CraneStatusLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CraneStatusResource extends Resource
{
    protected static ?string $model = CraneStatusLog::class;

    public static function getNavigationGroup(): string|null
    {
        return 'Flota';
    }


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSignal;


    protected static ?string $navigationLabel = 'Bitácora de Estado';

    protected static ?string $modelLabel = 'Registro de Estado';

    protected static ?string $pluralModelLabel = 'Bitácora de Estado';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'id';

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
