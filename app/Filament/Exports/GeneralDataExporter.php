<?php

namespace App\Filament\Exports;

use App\Models\GeneralData;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class GeneralDataExporter extends Exporter
{
    protected static ?string $model = GeneralData::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nombre_productor')
                ->label('Nombre del Productor'),

            ExportColumn::make('codigo')
                ->label('Codigo'),

            ExportColumn::make('numero_cedula')
                ->label('Cedula'),

            ExportColumn::make('nombre_finca')
                ->label('Nombre de la Finca'),

            ExportColumn::make('altura_nivel_mar')
                ->label('Altura sobre el Nivel del Mar'),

            ExportColumn::make('ciclo_productivo')
                ->label('Ciclo Productivo'),

            ExportColumn::make('coordenadas_area_cacao')
                ->label('Coordenadas Area Cacao'),

            ExportColumn::make('departamento')
                ->label('Departamento'),

            ExportColumn::make('municipio')
                ->label('Municipio'),

            ExportColumn::make('comunidad')
                ->label('Comunidad'),

            ExportColumn::make('area_total_finca')
                ->label('Area Total de la Finca'),

            ExportColumn::make('area_cacao')
                ->label('Area de Cacao'),

            ExportColumn::make('produccion')
                ->label('Produccion'),

            ExportColumn::make('desarrollo')
                ->label('Desarrollo'),

            ExportColumn::make('variedades_cacao')
                ->label('Variedades de Cacao')
                ->listAsJson(),

            ExportColumn::make('es_certificado')
                ->label('Certificado'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your general data export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
