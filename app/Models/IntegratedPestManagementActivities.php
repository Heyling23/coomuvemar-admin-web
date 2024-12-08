<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class IntegratedPestManagementActivities extends Model
{
    use HasFactory;

    use Sushi;

    protected $fillable = [
        'id',
        'nombre_apellido_aplicador',
        'plaga_enfermedad',
        'nivel_danio',
        'metodo_aplicado',
        'hora_aplicacion',
        'duracion_dias_metodo_aplicado',
        'resultado_aplicacion',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    protected static string $general_data_id;

    public static function setGeneralDataId($value): void
    {
        self::$general_data_id = $value;
    }

    /**
     * @throws Exception
     */
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
            $response = Http::get(BaseURL::$BASE_URL . "integrated-pest-management-activities/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombre_apellido_aplicador',
                        'plaga_enfermedad',
                        'nivel_danio',
                        'metodo_aplicado',
                        'hora_aplicacion',
                        'duracion_dias_metodo_aplicado',
                        'resultado_aplicacion',
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
