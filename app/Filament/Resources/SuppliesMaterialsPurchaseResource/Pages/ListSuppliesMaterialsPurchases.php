<?php

namespace App\Filament\Resources\SuppliesMaterialsPurchaseResource\Pages;

use App\Filament\Resources\SuppliesMaterialsPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuppliesMaterialsPurchases extends ListRecords
{
    protected static string $resource = SuppliesMaterialsPurchaseResource::class;

    protected static ?string $navigationLabel = 'Compras de insumos y materiales';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
