<?php

namespace App\Filament\Resources\PesticideApplicationResource\Pages;

use App\Filament\Resources\PesticideApplicationResource;
use App\Models\BaseURL;
use App\Models\FertilizerApplication;
use App\Models\PesticideApplication;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreatePesticideApplication extends CreateRecord
{
    protected static string $resource = PesticideApplicationResource::class;

    protected static ?string $navigationLabel = 'Crear Registro de aplicaciones de plaguicida';

    protected static ?string $title = "Crear Registro de aplicaciones de plaguicida";

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
        $supplies_id = explode('=', $this->previousUrl)[1];
        $url = BaseURL::$BASE_URL . 'pesticide-application-record/store/' . $supplies_id;
        PesticideApplication::setSuppliesId($supplies_id);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new PesticideApplication(
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
