<?php

namespace App\Models;

use App\Filament\Resources\HarvestRegistrationCocoaResource;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Sushi\Sushi;
use Throwable;

class HarvestRegistrationCocoa extends Model
{
    use HasFactory;

    use Sushi;

    protected $fillable = [
        'id',
        'fecha',
        'cantidad_mazorcas',
        'qq_baba_cacao',
        'precio_qq',
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
            $response = Http::get(BaseURL::$BASE_URL . "cocoa-harvest-registration/" . self::$general_data_id)->json();

            return Arr::map($response['data'], function ($item) {
                return Arr::only($item,
                    [
                        'id',
                        'fecha',
                        'cantidad_mazorcas',
                        'qq_baba_cacao',
                        'precio_qq',
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
