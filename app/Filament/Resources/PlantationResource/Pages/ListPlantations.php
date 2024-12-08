<?php

namespace App\Filament\Resources\PlantationResource\Pages;

use App\Filament\Resources\PlantationResource;
use Filament\Resources\Pages\ListRecords;

class ListPlantations extends ListRecords
{
    protected static string $resource = PlantationResource::class;

    protected static ?string $title = 'Poda de formación o mantenimiento';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
