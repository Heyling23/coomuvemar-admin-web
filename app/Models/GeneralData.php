<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class GeneralData extends Model
{
    use HasFactory;

    use Sushi;

    protected $fillable = [
        'nombre_productor',
        'codigo',
        'numero_cedula',
        'nombre_finca',
        'altura_nivel_mar',
        'ciclo_productivo',
        'coordenadas_area_cacao',
        'departamento',
        'municipio',
        'comunidad',
        'area_total_finca',
        'area_cacao',
        'produccion',
        'desarrollo',
        'variedades_cacao',
        'es_certificado',
        'bosquejo_finca'
    ];

    public function getRows(): array
    {
        $generalData = Http::get(BaseURL::$BASE_URL . "general-data/1")->json();

        try {
            return Arr::map($generalData['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombre_productor',
                        'codigo',
                        'numero_cedula',
                        'nombre_finca',
                        'altura_nivel_mar',
                        'ciclo_productivo',
                        'departamento',
                        'municipio',
                        'comunidad',
                        'coordenadas_area_cacao',
                        'area_total_finca',
                        'area_cacao',
                        'produccion',
                        'desarrollo',
                        'variedades_cacao',
                        'es_certificado',
                        'bosquejo_finca'
                    ]
                );
            });
        } catch (Throwable) {
            return [];
        }
    }
}
