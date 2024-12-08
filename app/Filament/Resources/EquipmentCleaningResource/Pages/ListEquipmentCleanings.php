<?php

namespace App\Filament\Resources\EquipmentCleaningResource\Pages;

use App\Filament\Resources\EquipmentCleaningResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentCleanings extends ListRecords
{
    protected static string $resource = EquipmentCleaningResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
