<?php

namespace App\Filament\Resources\PesticideApplicationResource\Pages;

use App\Filament\Resources\PesticideApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesticideApplications extends ListRecords
{
    protected static string $resource = PesticideApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
