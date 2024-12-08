<?php

namespace App\Filament\Resources\CocoaAreaActivitiesRegistryResource\Pages;

use App\Filament\Resources\CocoaAreaActivitiesRegistryResource;
use App\Models\BaseURL;
use App\Models\CocoaAreaActivitiesRegistry;
use Exception;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateCocoaAreaActivitiesRegistry extends CreateRecord
{
    protected static string $resource = CocoaAreaActivitiesRegistryResource::class;

    protected static ?string $navigationLabel = 'Crear Registro de Actividades Areas de Cacao';

    protected static ?string $title = "Crear Registro de Actividades Areas de Cacao";

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
        $url = BaseURL::$BASE_URL . 'cocoa-area-activities-registries/store/' . $generalDataId;
        CocoaAreaActivitiesRegistry::setRegistryTemporaryPermanentWorkersId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new CocoaAreaActivitiesRegistry(
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
