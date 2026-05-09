<?php

namespace App\Filament\Resources\CraneStatus\Pages;

use App\Filament\Resources\CraneStatus\CraneStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCraneStatusLogs extends ListRecords
{
    protected static string $resource = CraneStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Registrar Estado')];
    }
}
