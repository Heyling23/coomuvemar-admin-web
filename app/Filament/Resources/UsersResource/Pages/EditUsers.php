<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        $rol = $this->record["rol"];
        echo $rol;
        if ($rol === 'Administrador') {
            return [];
        } else {
            return [
                Actions\DeleteAction::make(),
            ];
        }
    }
}
