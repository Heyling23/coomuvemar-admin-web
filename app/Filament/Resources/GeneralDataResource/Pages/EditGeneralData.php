<?php

namespace App\Filament\Resources\GeneralDataResource\Pages;

use App\Filament\Resources\CoRecordResource;
use App\Filament\Resources\GeneralDataResource;
use App\Filament\Resources\RecordResource;
use App\Models\BaseURL;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class EditGeneralData extends EditRecord
{
    protected static string $resource = GeneralDataResource::class;

    protected static ?string $title = 'Editar Datos Generales';

    /**
     * @throws Exception
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $url = BaseURL::$BASE_URL . "general-data/update/" . $record->id;
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
        $url = BaseURL::$BASE_URL . "general-data/destroy/" . $record->id;
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
                ->modalHeading('Eliminar ' . $this->record->nombre_productor)
                ->modalCancelActionLabel('Cancelar')
                ->modalSubmitActionLabel('Eliminar')
                ->modalDescription('¿Seguro que desea eliminar el registro?')
                ->action(function (Model $record) {
                    return $this->handleDeleteRecord($record);
                }),
            Actions\Action::make('go_to_record')
                ->label('Registros')
                ->color('info')
                ->action(function () {
                    $this->redirect(
                        url: GeneralDataResource::getUrl() . '/' . $this->record['id'] . '/records',
                    );
                })
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
