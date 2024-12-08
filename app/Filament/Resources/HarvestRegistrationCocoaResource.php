<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralDataResource\Pages\Params;
use App\Filament\Resources\HarvestRegistrationCocoaResource\Pages;
use App\Models\HarvestRegistrationCocoa;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class HarvestRegistrationCocoaResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Registro de Cosechas de Cacao';

    protected static ?string $navigationLabel = 'Registro de Cosechas de Cacao';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cantidad_mazorcas')
                    ->label('Cantidad de mazorcas')
                    ->required(),

                TextInput::make('qq_baba_cacao')
                    ->label('QQ de cacao baba')
                    ->required(),

                TextInput::make('precio_qq')
                    ->label('Precio QQ')
                    ->required(),

                DatePicker::make('fecha')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        HarvestRegistrationCocoa::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('cantidad_mazorcas')
                    ->label('Cantidad de Mazorcas')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('qq_baba_cacao')
                    ->label('QQ de cacao baba')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('precio_qq')
                    ->label('Precio QQ')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('fecha')
                    ->label('Fecha')
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
            'index' => Pages\ListHarvestRegistrationCocoas::route('/'),
            'create' => Pages\CreateHarvestRegistrationCocoa::route('/create/{general_data_id}'),
            'edit' => Pages\EditHarvestRegistrationCocoa::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
