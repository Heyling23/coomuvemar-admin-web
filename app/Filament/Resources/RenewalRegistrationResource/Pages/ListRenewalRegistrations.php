<?php

namespace App\Filament\Resources\RenewalRegistrationResource\Pages;

use App\Filament\Resources\RenewalRegistrationResource;
use Filament\Resources\Pages\ListRecords;

class ListRenewalRegistrations extends ListRecords
{
    protected static string $resource = RenewalRegistrationResource::class;

    protected static ?string $title = 'Renovación o mejora genética';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
