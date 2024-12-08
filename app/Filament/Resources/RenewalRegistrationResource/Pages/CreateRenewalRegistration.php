<?php

namespace App\Filament\Resources\RenewalRegistrationResource\Pages;

use App\Filament\Resources\RenewalRegistrationResource;
use App\Models\BaseURL;
use App\Models\RenewalRegistration;
use Exception;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateRenewalRegistration extends CreateRecord
{
    protected static string $resource = RenewalRegistrationResource::class;

    protected static ?string $title = "Crear Renovación o mejora genética";

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
        $data['nombre_clones_injertados'] = explode(',', $data['nombre_clones_injertados']);

        $url = BaseURL::$BASE_URL . 'renewal-registration/store/' . $generalDataId;
        RenewalRegistration::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new RenewalRegistration(
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
