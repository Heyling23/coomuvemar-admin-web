<?php

namespace App\Filament\Resources\SuppliesMaterialsPurchaseResource\Pages;

use App\Filament\Resources\SuppliesMaterialsPurchaseResource;
use App\Models\BaseURL;
use App\Models\SuppliesMaterialsPurchase;
use Exception;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CreateSuppliesMaterialsPurchase extends CreateRecord
{
    protected static string $resource = SuppliesMaterialsPurchaseResource::class;

    protected static ?string $title = "Crear Compra de insumos y materiales";

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
        $url = BaseURL::$BASE_URL . 'supplies-materials-purchase-record/store/' . $generalDataId;
        SuppliesMaterialsPurchase::setGeneralDataId($generalDataId);
        $response = Http::post(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to create record: " . $response['message']);
        }
        return new SuppliesMaterialsPurchase(
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
