<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PestMonitoringRecordDiseasesBeneficialInsectsResource\Pages;
use App\Models\HarvestRegistrationCocoa;
use App\Models\PestMonitoringRecordDiseasesBeneficialInsects;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PestMonitoringRecordDiseasesBeneficialInsectsResource extends Resource
{
    protected static ?string $model = PestMonitoringRecordDiseasesBeneficialInsects::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $label = 'Registro de Monitoreo de Plagas, Enfermedades e Insectos Benéficos';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_plaga_enfermedad')
                    ->label('Nombre de la plaga o enfermedad')
                    ->required(),

                DatePicker::make('fecha_monitoreo')
                    ->label('Fecha de monitoreo')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),

                Section::make('Muestro 1')
                    ->columns([
                        'sm' => 2,
                    ])
                    ->schema([
                        TextInput::make('numero_plantas_afectadas_1')
                            ->label('Numero de plantas afectadas')
                            ->type('number')
                            ->required(),

                        TextInput::make('numero_mazorcas_afectadas_1')
                            ->label('Numero de mazorcas afectadas')
                            ->type('number')
                            ->required(),
                    ]),

                Section::make('Muestro 2')
                    ->columns([
                        'sm' => 2,
                    ])
                    ->schema([
                        TextInput::make('numero_plantas_afectadas_2')
                            ->label('Numero de plantas afectadas')
                            ->type('number')
                            ->required(),

                        TextInput::make('numero_mazorcas_afectadas_2')
                            ->label('Numero de mazorcas afectadas')
                            ->type('number')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        PestMonitoringRecordDiseasesBeneficialInsects::setGeneralDataId(request('general_data_id'));
        return $table
            ->emptyStateDescription(description: "Aun no hay registros para este modulo")
            ->emptyStateHeading(heading: "Sin informacion")
            ->paginated(false)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->url(fn() => static::getUrl(
                        'create',
                        [
                            'general_data_id' => request('general_data_id')
                        ]
                    ))
                    ->label('Crear Registro'),
            ])
            ->columns([
                TextColumn::make('fecha_monitoreo')
                    ->label('Fecha de monitoreo')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('nombre_plaga_enfermedad')
                    ->label('Nombre de la plaga o enfermedad')
                    ->weight('medium')
                    ->alignLeft(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(function (Model $record): string {
                        return static::getUrl(
                            'edit',
                            [
                                'record' => $record['id'],
                                'general_data_id' => request('general_data_id')
                            ]
                        );
                    })
                    ->label('Editar'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPestMonitoringRecordDiseasesBeneficialInsects::route('/'),
            'create' => Pages\CreatePestMonitoringRecordDiseasesBeneficialInsects::route('/create/{general_data_id}'),
            'edit' => Pages\EditPestMonitoringRecordDiseasesBeneficialInsects::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
