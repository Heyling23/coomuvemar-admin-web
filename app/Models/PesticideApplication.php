<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class PesticideApplication extends Model
{
    use HasFactory;

    use Sushi;

    protected $fillable = [
        'id',
        'nombres_apellidos_aplicadores',
        'plaga_enfermedad',
        'nombre_producto',
        'fecha_aplicacion',
        'hora_aplicacion',
        'onzas_dosis_bombadas',
        'lugar_cultivo_producto_aplicado',
        'mz_area_producto_aplicado',
        'litros_total_volumen_aplicado',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    protected static string $suppliesId;

    public static function setSuppliesId($value): void
    {
        self::$suppliesId = $value;
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
                    $suppliesMaterialsPurchaseRecordsId = $snapshotData['data']['data'][0]['general_data_id'];
                    self::$suppliesId = $suppliesMaterialsPurchaseRecordsId;
                }
            }
            $response = Http::get(BaseURL::$BASE_URL . "pesticide-application-record/" . self::$suppliesId)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombres_apellidos_aplicadores',
                        'plaga_enfermedad',
                        'nombre_producto',
                        'fecha_aplicacion',
                        'hora_aplicacion',
                        'onzas_dosis_bombadas',
                        'lugar_cultivo_producto_aplicado',
                        'mz_area_producto_aplicado',
                        'litros_total_volumen_aplicado',
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
