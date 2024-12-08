<?php

namespace App\Filament\Resources\GeneralDataResource\Pages;

use App\Filament\Resources\GeneralDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeneralData extends ListRecords
{
    protected static string $resource = GeneralDataResource::class;

    protected static ?string $title = 'Datos Generales';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Crear registro'),
        ];
    }
}
