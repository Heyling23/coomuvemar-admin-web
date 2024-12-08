<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class RenewalRegistration extends Model
{
    use HasFactory;

    use Sushi;

    protected static string $general_data_id;

    protected $fillable = [
        'id',
        'fecha_injertacion',
        'numero_plantas_injertada_por_mz',
        'nombre_clones_injertados',
        'nombre_proveedor',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'nombre_clones_injertados' => 'array'
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
            $response = Http::get(BaseURL::$BASE_URL . "renewal-registration/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                $item['nombre_clones_injertados'] = json_encode($item['nombre_clones_injertados']);
                return Arr::only($item,
                    [
                        'id',
                        'fecha_injertacion',
                        'numero_plantas_injertada_por_mz',
                        'nombre_clones_injertados',
                        'nombre_proveedor',
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
