<?php

namespace App\Filament\Resources\GeneralDataResource\Pages;

use App\Filament\Resources\GeneralDataResource;
use App\Models\BaseURL;
use App\Models\GeneralData;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateGeneralData extends CreateRecord
{
    protected static string $resource = GeneralDataResource::class;

    protected static ?string $title = "Crear Datos Generales";

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
        $userId = auth()->user()->getAuthIdentifier();
        $url = BaseURL::$BASE_URL . 'general-data/store/' . $userId;
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new GeneralData(
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
