<?php

namespace App\Filament\Resources\HarvestRegistrationCocoaResource\Pages;

use App\Filament\Resources\HarvestRegistrationCocoaResource;
use App\Models\BaseURL;
use App\Models\GeneralData;
use App\Models\HarvestRegistrationCocoa;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateHarvestRegistrationCocoa extends CreateRecord
{
    protected static string $resource = HarvestRegistrationCocoaResource::class;

    protected static ?string $title = "Crear Registro de Cosechas de Cacao";

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
        $url = BaseURL::$BASE_URL . 'cocoa-harvest-registration/store/' . $generalDataId;
        HarvestRegistrationCocoa::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new HarvestRegistrationCocoa(
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
