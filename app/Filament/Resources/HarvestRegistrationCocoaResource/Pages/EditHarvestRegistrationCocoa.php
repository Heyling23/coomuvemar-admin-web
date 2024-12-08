<?php

namespace App\Filament\Resources\HarvestRegistrationCocoaResource\Pages;

use App\Filament\Resources\HarvestRegistrationCocoaResource;
use App\Models\BaseURL;
use App\Models\HarvestRegistrationCocoa;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class EditHarvestRegistrationCocoa extends EditRecord
{
    protected static string $resource = HarvestRegistrationCocoaResource::class;

    protected static ?string $title = 'Editar Registro de Cosechas de Cacao';


    public function mount(int|string $record): void
    {
        HarvestRegistrationCocoa::setGeneralDataId(request('general_data_id'));
        parent::mount($record);
    }

    /**
     * @throws Exception
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $url = BaseURL::$BASE_URL . 'cocoa-harvest-registration/update/' . $record['id'];
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
        $url = BaseURL::$BASE_URL . 'cocoa-harvest-registration/destroy/' . $record['id'];
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
