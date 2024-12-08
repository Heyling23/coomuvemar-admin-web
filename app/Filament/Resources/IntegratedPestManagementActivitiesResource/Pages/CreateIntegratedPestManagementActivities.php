<?php

namespace App\Filament\Resources\IntegratedPestManagementActivitiesResource\Pages;

use App\Filament\Resources\IntegratedPestManagementActivitiesResource;
use App\Models\BaseURL;
use App\Models\IntegratedPestManagementActivities;
use App\Models\Plantation;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateIntegratedPestManagementActivities extends CreateRecord
{
    protected static string $resource = IntegratedPestManagementActivitiesResource::class;

    protected static ?string $title = "Crear Actividad de manejo integrado de plagas en la finca";

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

        $url = BaseURL::$BASE_URL . 'integrated-pest-management-activities/store/' . $generalDataId;
        IntegratedPestManagementActivities::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new IntegratedPestManagementActivities(
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
