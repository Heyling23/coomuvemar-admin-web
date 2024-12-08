<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class FertilizerApplication extends Model
{
    use HasFactory;

    use Sushi;

    protected $fillable = [
        'id',
        'nombre_fertilizante',
        'lugar_aplicacion',
        'tipo_insumo',
        'procedencia_fertilizante',
        'dosis_planta',
        'dosis_manzana',
        'veces_aplicado_anio',
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
            $response = Http::get(BaseURL::$BASE_URL . "fertilizer-application-record/" . self::$suppliesId)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombre_fertilizante',
                        'lugar_aplicacion',
                        'tipo_insumo',
                        'procedencia_fertilizante',
                        'dosis_planta',
                        'dosis_manzana',
                        'veces_aplicado_anio',
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
