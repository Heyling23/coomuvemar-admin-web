<?php

namespace App\Filament\Resources\GeneralDataResource\Pages;

use App\Filament\Resources\CocoaAreaActivitiesRegistryResource;
use App\Filament\Resources\EquipmentCleaningResource;
use App\Filament\Resources\FertilizerApplicationResource;
use App\Filament\Resources\GeneralDataResource;
use App\Filament\Resources\GeneralDataResource\Widgets\RecordWidget;
use App\Filament\Resources\HarvestRegistrationCocoaResource;
use App\Filament\Resources\IntegratedPestManagementActivitiesResource;
use App\Filament\Resources\PesticideApplicationResource;
use App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource;
use App\Filament\Resources\PlantationResource;
use App\Filament\Resources\RenewalRegistrationResource;
use App\Filament\Resources\SuppliesMaterialsPurchaseResource;
use App\Filament\Resources\TemporaryPermanentWorkersResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class ViewRecords extends Page
{
    protected static string $resource = GeneralDataResource::class;

    protected static ?string $title = 'Registros';

    protected static string $view = 'filament.resources.general-data-resource.pages.records';

    private int $generalDataId;

    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 2;
    }

    public function render(): View
    {
        $this->generalDataId = request('record');
        return parent::render();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Actividades en las Áreas de Cacao',
                    'action' => CocoaAreaActivitiesRegistryResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Trabajadores Temporales y Permanentes',
                    'action' => TemporaryPermanentWorkersResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Monitoreo de Plagas, Enfermedades e Insectos Benéficos',
                    'action' => PestMonitoringRecordDiseasesBeneficialInsectsResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Actividades de Manejo Integrado de Plagas en la Finca',
                    'action' => IntegratedPestManagementActivitiesResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Compra de Insumos y Materiales',
                    'action' => SuppliesMaterialsPurchaseResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Aplicación de Plaguicidas',
                    'action' => PesticideApplicationResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Aplicación de Abonos (Fertilización)',
                    'action' => FertilizerApplicationResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Limpieza de Equipos',
                    'action' => EquipmentCleaningResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Renovación (Cambio de Copa) o Mejora Genética (Injertación)',
                    'action' => RenewalRegistrationResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Poda de formación o mantenimiento',
                    'action' => PlantationResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            ),
            RecordWidget::make(
                properties: [
                    'title' => 'Registro de Cosecha de Cacao',
                    'action' => HarvestRegistrationCocoaResource::getUrl(
                        parameters: [
                            'general_data_id' => $this->generalDataId,
                        ]
                    )
                ]
            )
        ];
    }
}
