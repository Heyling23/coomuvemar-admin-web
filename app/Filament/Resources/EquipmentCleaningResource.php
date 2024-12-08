<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentCleaningResource\Pages;
use App\Models\EquipmentCleaning;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class EquipmentCleaningResource extends Resource
{
    protected static ?string $model = EquipmentCleaning::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('actividad')
                    ->label('Actividad')
                    ->required(),

                DatePicker::make('fecha_uso')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),

                TagsInput::make('productos_usados_limpiar_producto')
                    ->label('Productos usados limpiar el equipo')
                    ->separator(',')
                    ->required(),

                TextInput::make('equipo')
                    ->label('Equipo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        EquipmentCleaning::setGeneralDataId(request('general_data_id'));
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

                TextColumn::make('fecha_uso')
                    ->label('Fecha de uso')
                    ->weight('medium')
                    ->alignLeft(),

                Tables\Columns\TagsColumn::make('productos_usados_limpiar_producto')
                    ->label('Productos uasdos para el limpiar el equipo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('equipo')
                    ->label('Equipo')
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
            'index' => Pages\ListEquipmentCleanings::route('/'),
            'create' => Pages\CreateEquipmentCleaning::route('/create/{general_data_id}'),
            'edit' => Pages\EditEquipmentCleaning::route('/{record}/edit{general_data_id}'),
        ];
    }
}
