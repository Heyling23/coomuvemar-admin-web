<?php

namespace App\Filament\Resources\SuppliesMaterialsPurchaseResource\Pages;

use App\Filament\Resources\CocoaAreaActivitiesRegistryResource;
use App\Filament\Resources\FertilizerApplicationResource;
use App\Filament\Resources\PesticideApplicationResource;
use App\Filament\Resources\SuppliesMaterialsPurchaseResource;
use App\Models\BaseURL;
use App\Models\RenewalRegistration;
use App\Models\SuppliesMaterialsPurchase;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class EditSuppliesMaterialsPurchase extends EditRecord
{
    protected static string $resource = SuppliesMaterialsPurchaseResource::class;

    protected static ?string $title = 'Editar Compra de insumos y materiales';


    public function mount(int|string $record): void
    {
        SuppliesMaterialsPurchase::setGeneralDataId(request('general_data_id'));
        parent::mount($record);
    }

    /**
     * @throws Exception
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $url = BaseURL::$BASE_URL . 'supplies-materials-purchase-record/update/' . $record['id'];
        $response = Http::put(
            url: $url,
            data: $data
        )->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to update record: " . $response['message']);
        }
        return $record;
    }

    /**
     * @throws Exception
     */
    private function handleDeleteRecord(Model $record): bool
    {
        $url = BaseURL::$BASE_URL . 'supplies-materials-purchase-record/destroy/' . $record['id'];
        $response = Http::delete($url)->json();
        if ($response['status'] === false) {
            throw new Exception("Failed to delete record: " . $response['message']);
        }
        $this->redirect(
            url: $this->previousUrl ?? $this->getResource()::getUrl('index'),
        );
        return true;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Registro actualizado';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Eliminar')
                ->modalHeading('Eliminar')
                ->modalCancelActionLabel('Cancelar')
                ->modalSubmitActionLabel('Eliminar')
                ->modalDescription('¿Seguro que desea eliminar el registro?')
                ->action(function (Model $record): bool {
                    return $this->handleDeleteRecord($record);
                }),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->label('Guardar');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Cancelar');
    }
}
