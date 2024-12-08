<?php

namespace App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource\Pages;

use App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource;
use App\Models\BaseURL;
use App\Models\PestMonitoringRecordDiseasesBeneficialInsects;
use Exception;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreatePestMonitoringRecordDiseasesBeneficialInsects extends CreateRecord
{
    protected static string $resource = PestMonitoringRecordDiseasesBeneficialInsectsResource::class;

    protected static ?string $title = "Crear Monitoreo de plagas, enfermedades e insectos benéfico";

    protected static bool $canCreateAnother = false;

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar');
    }

    /**
     * @throws Exception
     */
    protected function handleRecordCreation(array $data): Model
    {
        $generalDataId = explode('=', $this->previousUrl)[1];

        $url = BaseURL::$BASE_URL . 'pest-monitoring-record-diseases-beneficial-insects/store/' . $generalDataId;
        PestMonitoringRecordDiseasesBeneficialInsects::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new PestMonitoringRecordDiseasesBeneficialInsects(
            attributes: $response['data']
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Registro creado';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Crear Registro');
    }
}
