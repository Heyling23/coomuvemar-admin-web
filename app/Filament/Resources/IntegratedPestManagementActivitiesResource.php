<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntegratedPestManagementActivitiesResource\Pages;
use App\Models\IntegratedPestManagementActivities;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class IntegratedPestManagementActivitiesResource extends Resource
{
    protected static ?string $model = IntegratedPestManagementActivities::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_apellido_aplicador')
                    ->label('Nombre y apellido del aplicador')
                    ->required(),

                TextInput::make('plaga_enfermedad')
                    ->label('Plaga o enfermedad')
                    ->required(),

                TextInput::make('nivel_danio')
                    ->label('Nivel de daño')
                    ->required(),

                TextInput::make('metodo_aplicado')
                    ->label('Método aplicado')
                    ->required(),

                TextInput::make('hora_aplicacion')
                    ->label('Hora de aplicacion')
                    ->required(),

                TextInput::make('duracion_dias_metodo_aplicado')
                    ->label('Duracion de dias del metodo aplicado')
                    ->required(),

                TextInput::make('resultado_aplicacion')
                    ->label('Resultado de la aplicacion')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        IntegratedPestManagementActivities::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('nombre_apellido_aplicador')
                    ->label('Nombre y apellido del aplicador')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('plaga_enfermedad')
                    ->label('Plaga o enfermedad')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('nivel_danio')
                    ->label('Nivel de daño')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('metodo_aplicado')
                    ->label('Método aplicado')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('duracion_dias_metodo_aplicado')
                    ->label('Duracion de dias del metodo aplicado')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('resultado_aplicacion')
                    ->label('Resultado de la aplicacion')
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
            'index' => Pages\ListIntegratedPestManagementActivities::route('/'),
            'create' => Pages\CreateIntegratedPestManagementActivities::route('/create/{general_data_id}'),
            'edit' => Pages\EditIntegratedPestManagementActivities::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
