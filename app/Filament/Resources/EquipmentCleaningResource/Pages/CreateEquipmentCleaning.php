<?php

namespace App\Filament\Resources\EquipmentCleaningResource\Pages;

use App\Filament\Resources\EquipmentCleaningResource;
use App\Models\BaseURL;
use App\Models\EquipmentCleaning;
use App\Models\HarvestRegistrationCocoa;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateEquipmentCleaning extends CreateRecord
{
    protected static string $resource = EquipmentCleaningResource::class;

    protected static ?string $title = "Crear Registro de equipo de limpieza";

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
        $data['productos_usados_limpiar_producto'] = explode(',', $data['productos_usados_limpiar_producto']);
        $url = BaseURL::$BASE_URL . 'equipment-cleaning-registration/store/' . $generalDataId;
        EquipmentCleaning::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new EquipmentCleaning(
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
