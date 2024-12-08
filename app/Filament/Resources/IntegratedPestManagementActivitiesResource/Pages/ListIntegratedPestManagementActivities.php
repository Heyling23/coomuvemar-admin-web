<?php

namespace App\Filament\Resources\IntegratedPestManagementActivitiesResource\Pages;

use App\Filament\Resources\IntegratedPestManagementActivitiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIntegratedPestManagementActivities extends ListRecords
{
    protected static string $resource = IntegratedPestManagementActivitiesResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
