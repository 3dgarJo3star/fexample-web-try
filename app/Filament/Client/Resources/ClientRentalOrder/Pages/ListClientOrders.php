<?php

namespace App\Filament\Client\Resources\ClientRentalOrder\Pages;

use App\Filament\Client\Resources\ClientRentalOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListClientOrders extends ListRecords
{
    protected static string $resource = ClientRentalOrderResource::class;
}
