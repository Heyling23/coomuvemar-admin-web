<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class EquipmentCleaning extends Model
{
    use HasFactory;

    use Sushi;

    protected static string $general_data_id;
    protected $fillable = [
        'id',
        'actividad',
        'equipo',
        'fecha_uso',
        'productos_usados_limpiar_producto',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'productos_usados_limpiar_producto' => 'array'
    ];

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
            $response = Http::get(BaseURL::$BASE_URL . "equipment-cleaning-registration/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                $item['productos_usados_limpiar_producto'] = json_encode($item['productos_usados_limpiar_producto']);
                return Arr::only($item,
                    [
                        'id',
                        'actividad',
                        'equipo',
                        'fecha_uso',
                        'productos_usados_limpiar_producto',
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
