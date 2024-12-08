<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class SuppliesMaterialsPurchase extends Model
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
        'nombre_producto',
        'unidad_medida',
        'cantidad',
        'fecha_compra',
        'categoria',
        'costo_unitario',
        'costo_total',
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
            $response = Http::get(BaseURL::$BASE_URL . "supplies-materials-purchase-record/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'nombre_producto',
                        'unidad_medida',
                        'cantidad',
                        'fecha_compra',
                        'categoria',
                        'costo_unitario',
                        'costo_total',
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
