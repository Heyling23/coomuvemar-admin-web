<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;
use Throwable;

class PestMonitoringRecordDiseasesBeneficialInsects extends Model
{
    use HasFactory;

    use Sushi;

    protected static string $general_data_id;

    protected $fillable = [
        'id',
        'fecha_monitoreo',
        'nombre_plaga_enfermedad',
        'numero_plantas_afectadas_2',
        'numero_mazorcas_afectadas_2',
        'numero_plantas_afectadas_1',
        'numero_mazorcas_afectadas_1',
        'general_data_id',
        'created_at',
        'updated_at',
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
            $response = Http::get(BaseURL::$BASE_URL . "pest-monitoring-record-diseases-beneficial-insects/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'fecha_monitoreo',
                        'nombre_plaga_enfermedad',
                        'numero_plantas_afectadas_2',
                        'numero_mazorcas_afectadas_2',
                        'numero_plantas_afectadas_1',
                        'numero_mazorcas_afectadas_1',
                        'general_data_id',
                        'created_at',
                        'updated_at',
                    ]
                );
            });
        } catch (Throwable $exception) {
            throw new Exception('Something went wrong: ' . $exception->getMessage());
        }
    }
}
