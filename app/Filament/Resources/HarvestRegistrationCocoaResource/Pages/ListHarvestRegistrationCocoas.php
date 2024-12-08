<?php

namespace App\Filament\Resources\HarvestRegistrationCocoaResource\Pages;

use App\Filament\Resources\HarvestRegistrationCocoaResource;
use Filament\Resources\Pages\ListRecords;

class ListHarvestRegistrationCocoas extends ListRecords
{
    protected static string $resource = HarvestRegistrationCocoaResource::class;

    protected static ?string $title = 'Registro de Cosechas de Cacao';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
