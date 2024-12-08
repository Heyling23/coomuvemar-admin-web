<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class CocoaAreaActivitiesRegistry extends Model
{
    use HasFactory;

    use Sushi;

    protected static string $registry_temporary_permanent_workers_id;

    protected $fillable = [
        'id',
        'actividad',
        'nombre_trabajador',
        'sexo',
        'cedula',
        'dias_trabajados',
        'pago_dia',
        'pago_total',
        'pago_mensual',
        'fecha_pago',
        'firma',
        'general_data_id',
        'created_at',
        'updated_at',
    ];

    public static function setRegistryTemporaryPermanentWorkersId($value): void
    {
        self::$registry_temporary_permanent_workers_id = $value;
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
                    $registry_temporary_permanent_workers_id = $snapshotData['data']['data'][0]['general_data_id'];
                    self::$registry_temporary_permanent_workers_id = $registry_temporary_permanent_workers_id;
                }
            }
            $response = Http::get(BaseURL::$BASE_URL . "cocoa-area-activities-registries/" . self::$registry_temporary_permanent_workers_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'actividad',
                        'nombre_trabajador',
                        'sexo',
                        'cedula',
                        'dias_trabajados',
                        'pago_dia',
                        'pago_total',
                        'pago_mensual',
                        'fecha_pago',
                        'firma',
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
