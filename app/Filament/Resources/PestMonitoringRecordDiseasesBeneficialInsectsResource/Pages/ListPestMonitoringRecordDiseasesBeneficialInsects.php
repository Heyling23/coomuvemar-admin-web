<?php

namespace App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource\Pages;

use App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPestMonitoringRecordDiseasesBeneficialInsects extends ListRecords
{
    protected static string $resource = PestMonitoringRecordDiseasesBeneficialInsectsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
