<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FertilizerApplicationResource\Pages;
use App\Filament\Resources\FertilizerApplicationResource\RelationManagers;
use App\Models\CocoaAreaActivitiesRegistry;
use App\Models\FertilizerApplication;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FertilizerApplicationResource extends Resource
{
    protected static ?string $model = FertilizerApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'Registro de aplicacion de abonos';

    protected static ?string $label = 'Registro de aplicacion de abonos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_fertilizante')
                    ->label('Nombre del fertilizante')
                    ->required(),

                Select::make('lugar_aplicacion')
                    ->options([
                        'Suelo' => 'Suelo',
                        'Follaje' => 'Follaje',
                    ])
                    ->required()
                    ->native(false),

                Select::make('tipo_insumo')
                    ->label('Tipo de insumo')
                    ->required()
                    ->options([
                        'Quimico' => 'Quimico',
                        'Organico' => 'Organico',
                    ])
                    ->native(false),

                TextInput::make('procedencia_fertilizante')
                    ->label('Procedencia del fertilizante')
                    ->required(),

                TextInput::make('dosis_planta')
                    ->label('Dosis por planta')
                    ->required(),

                TextInput::make('dosis_manzana')
                    ->label('Pago por manzana')
                    ->required(),

                TextInput::make('veces_aplicado_anio')
                    ->label('Veces aplicado al año')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        FertilizerApplication::setSuppliesId(request('general_data_id'));
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
                TextColumn::make('nombre_fertilizante')
                    ->label('Nombre del fertilizante')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('lugar_aplicacion')
                    ->label('Lugar de aplicacion')
                    ->weight('medium')
                    ->alignLeft(),


                TextColumn::make('tipo_insumo')
                    ->label('Tipo de Insumo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('procedencia_fertilizante')
                    ->label('Procedencia del fertilizante')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('dosis_planta')
                    ->label('Dosis por planta')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('dosis_manzana')
                    ->label('Dosis por manzana')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('veces_aplicado_anio')
                    ->label('Veces aplicado al año')
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
            'index' => Pages\ListFertilizerApplications::route('/'),
            'create' => Pages\CreateFertilizerApplication::route('/create/{general_data_id}'),
            'edit' => Pages\EditFertilizerApplication::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
