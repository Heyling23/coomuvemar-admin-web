<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesticideApplicationResource\Pages;
use App\Models\PesticideApplication;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PesticideApplicationResource extends Resource
{
    protected static ?string $model = PesticideApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'Registro de aplicacion de plaguicidas';

    protected static ?string $label = 'Registro de aplicacion de plaguicidas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombres_apellidos_aplicadores')
                    ->label('Nombre y apellido del aplicante')
                    ->required(),

                TextInput::make('plaga_enfermedad')
                    ->label('Plaga o enfermedad')
                    ->required(),

                TextInput::make('nombre_producto')
                    ->label('Nombre del producto')
                    ->required(),

                TextInput::make('hora_aplicacion')
                    ->label('Hora de aplicacion')
                    ->required(),

                TextInput::make('onzas_dosis_bombadas')
                    ->label('Dosis por bombada (onzas)')
                    ->required(),

                TextInput::make('lugar_cultivo_producto_aplicado')
                    ->label('Lugar o cultivo')
                    ->required(),

                TextInput::make('mz_area_producto_aplicado')
                    ->label('Area (mz)')
                    ->required(),

                TextInput::make('litros_total_volumen_aplicado')
                    ->label('Vomumen aplicado (Litros)')
                    ->required(),

                DatePicker::make('fecha_aplicacion')
                    ->label('Fecha de aplicacion')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        PesticideApplication::setSuppliesId(request('general_data_id'));
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
                TextColumn::make('nombres_apellidos_aplicadores')
                    ->label('Nombre y apellido del aplicante')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('plaga_enfermedad')
                    ->label('Plaga o enfermedad')
                    ->weight('medium')
                    ->alignLeft(),


                TextColumn::make('nombre_producto')
                    ->label('Nombre del producto')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('fecha_aplicacion')
                    ->label('Fecha de aplicacion')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('hora_aplicacion')
                    ->label('Hora de aplicacion')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('onzas_dosis_bombadas')
                    ->label('Dosis por bombada (onzas)')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('lugar_cultivo_producto_aplicado')
                    ->label('Lugar o cultivo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('mz_area_producto_aplicado')
                    ->label('Area (mz)')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('litros_total_volumen_aplicado')
                    ->label('Vomumen aplicado (Litros)')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPesticideApplications::route('/'),
            'create' => Pages\CreatePesticideApplication::route('/create/{general_data_id}'),
            'edit' => Pages\EditPesticideApplication::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
