<?php

namespace App\Filament\Resources\TemporaryPermanentWorkersResource\Pages;

use App\Filament\Resources\TemporaryPermanentWorkersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemporaryPermanentWorkers extends ListRecords
{
    protected static string $resource = TemporaryPermanentWorkersResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
