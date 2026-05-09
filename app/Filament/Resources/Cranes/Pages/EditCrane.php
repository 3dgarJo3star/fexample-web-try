<?php

namespace App\Filament\Resources\Cranes\Pages;

use App\Filament\Resources\Cranes\CraneResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCrane extends EditRecord
{
    protected static string $resource = CraneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
