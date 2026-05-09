<?php

namespace App\Filament\Resources\Cranes;

use App\Filament\Resources\Cranes\Pages\CreateCrane;
use App\Filament\Resources\Cranes\Pages\EditCrane;
use App\Filament\Resources\Cranes\Pages\ListCranes;
use App\Filament\Resources\Cranes\Pages\ViewCrane;
use App\Filament\Resources\Cranes\Schemas\CraneForm;
use App\Filament\Resources\Cranes\Schemas\CraneInfolist;
use App\Filament\Resources\Cranes\Tables\CranesTable;
use App\Models\Crane;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CraneResource extends Resource
{
    protected static ?string $model = Crane::class;

    public static function getNavigationGroup(): string|null
    {
        return 'Flota';
    }


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;


    protected static ?string $navigationLabel = 'Grúas';

    protected static ?string $modelLabel = 'Grúa';

    protected static ?string $pluralModelLabel = 'Grúas';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CraneForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CraneInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CranesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCranes::route('/'),
            'create' => CreateCrane::route('/create'),
            'view' => ViewCrane::route('/{record}'),
            'edit' => EditCrane::route('/{record}/edit'),
        ];
    }
}
