<?php

namespace App\Filament\Resources\FertilizerApplicationResource\Pages;

use App\Filament\Resources\FertilizerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFertilizerApplications extends ListRecords
{
    protected static string $resource = FertilizerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
