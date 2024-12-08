<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantationResource\Pages;
use App\Models\Plantation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PlantationResource extends Resource
{
    protected static ?string $model = Plantation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Poda de formación o mantenimiento';

    protected static ?string $navigationLabel = 'Poda de formación o mantenimiento';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tipo_poda')
                    ->label('Tipo de poda')
                    ->required(),

                TextInput::make('numero_plantas_podadas')
                    ->label('Numero de plantas podadas')
                    ->required(),

                DatePicker::make('fecha_podada')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),

                TextInput::make('mz_area_podada')
                    ->label('Area podada (mz)')
                    ->required(),

                TextInput::make('tipo_plantacion')
                    ->label('Tipo de plantacion')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        Plantation::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('tipo_poda')
                    ->label('Tipo de poda')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('numero_plantas_podadas')
                    ->label('Numero de plantas podadas')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('fecha_podada')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('mz_area_podada')
                    ->label('Area podada (mz)')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('tipo_plantacion')
                    ->label('Tipo de plantacion')
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
            'index' => Pages\ListPlantations::route('/'),
            'create' => Pages\CreatePlantation::route('/create/{general_data_id}'),
            'edit' => Pages\EditPlantation::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
