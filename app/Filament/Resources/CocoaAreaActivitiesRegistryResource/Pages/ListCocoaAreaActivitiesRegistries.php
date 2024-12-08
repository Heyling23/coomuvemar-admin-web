<?php

namespace App\Filament\Resources\CocoaAreaActivitiesRegistryResource\Pages;

use App\Filament\Resources\CocoaAreaActivitiesRegistryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCocoaAreaActivitiesRegistries extends ListRecords
{
    protected static string $resource = CocoaAreaActivitiesRegistryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
