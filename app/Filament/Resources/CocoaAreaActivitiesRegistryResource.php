<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CocoaAreaActivitiesRegistryResource\Pages;
use App\Models\CocoaAreaActivitiesRegistry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CocoaAreaActivitiesRegistryResource extends Resource
{
    protected static ?string $model = CocoaAreaActivitiesRegistry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationLabel = 'Registro de Actividades Areas de Cacao';

    protected static ?string $label = 'Registro de Actividades Areas de Cacao';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('actividad')
                    ->required(),

                TextInput::make('nombre_trabajador')
                    ->label('Nombre del trabajador')
                    ->required(),

                TextInput::make('sexo')
                    ->required(),

                TextInput::make('cedula')
                    ->required(),

                TextInput::make('dias_trabajados')
                    ->required(),

                TextInput::make('pago_dia')
                    ->label('Pago por dia')
                    ->required(),

                TextInput::make('pago_total')
                    ->required(),

                TextInput::make('pago_mensual')
                    ->required(),

                TextInput::make('firma')
                    ->required(),

                DatePicker::make('fecha_pago')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        CocoaAreaActivitiesRegistry::setRegistryTemporaryPermanentWorkersId(request('general_data_id'));
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
                TextColumn::make('actividad')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('nombre_trabajador')
                    ->label('Nombre del trabajador')
                    ->weight('medium')
                    ->alignLeft(),


                TextColumn::make('sexo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('cedula')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('dias_trabajados')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('pago_dia')
                    ->label('Pago por dia')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('pago_total')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('pago_mensual')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('fecha_pago')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('firma')
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
            'index' => Pages\ListCocoaAreaActivitiesRegistries::route('/'),
            'create' => Pages\CreateCocoaAreaActivitiesRegistry::route('/create/{general_data_id}'),
            'edit' => Pages\EditCocoaAreaActivitiesRegistry::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
