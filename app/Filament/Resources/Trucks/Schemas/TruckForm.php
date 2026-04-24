<?php

namespace App\Filament\Resources\Trucks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TruckForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                TextInput::make('color')
                    ->required(),
                TextInput::make('plate')
                    ->required(),
                TextInput::make('driver')
                    ->required(),
            ]);
    }
}
