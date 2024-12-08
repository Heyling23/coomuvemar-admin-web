<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class TemporaryPermanentWorkers extends Model
{
    use HasFactory;

    use Sushi;

    protected static string $general_data_id;

    public static function setGeneralDataId($value): void
    {
        self::$general_data_id = $value;
    }

    protected $fillable = [
        'id',
        'nombres_apellidos',
        'sexo',
        'cedula',
        'es_temporal',
        'numero_dias_trabajados_mes',
        'numero_dias_trabajados_anio',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    public function getRows(): array
    {
        try {
            $data = request()->get('components');

            if (is_array($data) && isset($data[0]['snapshot'])) {
                $snapshotData = json_decode($data[0]['snapshot'], true);
                if (is_array($snapshotData) && isset($snapshotData['data']['data'][0]['general_data_id'])) {
                    $generalDataId = $snapshotData['data']['data'][0]['general_data_id'];
                    self::$general_data_id = $generalDataId;
                }
            }
            $response = Http::get(BaseURL::$BASE_URL . "registry-temporary-permanent-workers/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombres_apellidos',
                        'sexo',
                        'cedula',
                        'es_temporal',
                        'numero_dias_trabajados_mes',
                        'numero_dias_trabajados_anio',
                        'general_data_id',
                        'created_at',
                        'updated_at',
                    ]
                );
            });
        } catch (Throwable $exception) {
            return [];
        }
    }
}
