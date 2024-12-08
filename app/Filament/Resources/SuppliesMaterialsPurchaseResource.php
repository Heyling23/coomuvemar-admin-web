<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuppliesMaterialsPurchaseResource\Pages;
use App\Models\SuppliesMaterialsPurchase;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SuppliesMaterialsPurchaseResource extends Resource
{
    protected static ?string $model = SuppliesMaterialsPurchase::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_producto')
                    ->label('Nombre del producto')
                    ->required(),

                TextInput::make('unidad_medida')
                    ->label('Unidad de medida')
                    ->required(),

                TextInput::make('cantidad')
                    ->required(),

                TextInput::make('categoria')
                    ->label('Nombre del producto')
                    ->required(),

                TextInput::make('costo_unitario')
                    ->required(),

                TextInput::make('costo_total')
                    ->required(),

                DatePicker::make('fecha_compra')
                    ->label('Fecha de compra')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        SuppliesMaterialsPurchase::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('nombre_producto')
                    ->label('Nombre del producto')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('cantidad')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('unidad_medida')
                    ->label('Unidad de medida')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('categoria')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('costo_unitario')
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('fecha_compra')
                    ->label('Fecha de compra')
                    ->sortable()
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
            'index' => Pages\ListSuppliesMaterialsPurchases::route('/'),
            'create' => Pages\CreateSuppliesMaterialsPurchase::route('/create/{general_data_id}'),
            'edit' => Pages\EditSuppliesMaterialsPurchase::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
