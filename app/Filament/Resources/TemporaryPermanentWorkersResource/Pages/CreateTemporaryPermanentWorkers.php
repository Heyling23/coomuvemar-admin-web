<?php

namespace App\Filament\Resources\TemporaryPermanentWorkersResource\Pages;

use App\Filament\Resources\TemporaryPermanentWorkersResource;
use App\Models\BaseURL;
use App\Models\TemporaryPermanentWorkers;
use Exception;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateTemporaryPermanentWorkers extends CreateRecord
{
    protected static string $resource = TemporaryPermanentWorkersResource::class;

    protected static ?string $title = "Crear Registro Trabajadores temporales y permanentes";

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
        $url = BaseURL::$BASE_URL . 'registry-temporary-permanent-workers/store/' . $generalDataId;
        TemporaryPermanentWorkers::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new TemporaryPermanentWorkers(
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
