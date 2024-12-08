<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemporaryPermanentWorkersResource\Pages;
use App\Models\TemporaryPermanentWorkers;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TemporaryPermanentWorkersResource extends Resource
{
    protected static ?string $model = TemporaryPermanentWorkers::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $label = 'Registros de trabajadores temporales y permanentes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombres_apellidos')
                    ->label('Nombres y apellidos')
                    ->required(),

                TextInput::make('sexo')
                    ->required(),

                TextInput::make('cedula')
                    ->required(),

                Checkbox::make('es_temporal')
                    ->label('Es temporal'),

                TextInput::make('numero_dias_trabajados_mes')
                    ->label('Numero de dias trabajados por mes')
                    ->required(),

                TextInput::make('numero_dias_trabajados_anio')
                    ->label('Numero de dias trabajados por año')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        TemporaryPermanentWorkers::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('nombres_apellidos')
                    ->label('Nombres y apellidos')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('sexo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('cedula')
                    ->weight('medium')
                    ->alignLeft(),

                Tables\Columns\CheckboxColumn::make('es_temporal')
                    ->label('Es temporal')
                    ->alignLeft(),

                TextColumn::make('numero_dias_trabajados_mes')
                    ->label('Numero de dias trabajados por mes')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('numero_dias_trabajados_anio')
                    ->weight('medium')
                    ->label('Numero de dias trabajados por año')
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
            'index' => Pages\ListTemporaryPermanentWorkers::route('/'),
            'create' => Pages\CreateTemporaryPermanentWorkers::route('/create/{general_data_id}'),
            'edit' => Pages\EditTemporaryPermanentWorkers::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
