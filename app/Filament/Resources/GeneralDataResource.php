<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralDataResource\Pages;
use App\Models\GeneralData;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class GeneralDataResource extends Resource
{
    protected static ?string $model = GeneralData::class;

    protected static ?string $label = 'Datos Generales';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Datos Generales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_productor')
                    ->label('Nombre del productor')
                    ->required(),

                TextInput::make('codigo')
                    ->label('Codigo')
                    ->required(),

                TextInput::make('numero_cedula')
                    ->label('Cédula')
                    ->required(),

                TextInput::make('nombre_finca')
                    ->label('Nombre de la finca')
                    ->required(),

                TextInput::make('altura_nivel_mar')
                    ->label('Altura del nivel del mar')
                    ->required(),

                TextInput::make('ciclo_productivo')
                    ->required(),

                TextInput::make('coordenadas_area_cacao')
                    ->label('Coordenadas del área de cacao')
                    ->required(),

                TextInput::make('area_total_finca')
                    ->label('Área total de la finca')
                    ->required(),

                TextInput::make('departamento')
                    ->required(),

                TextInput::make('municipio')
                    ->required(),

                TextInput::make('comunidad')
                    ->required(),

                TextInput::make('area_cacao')
                    ->label('Área del cacao')
                    ->required(),

                TextInput::make('produccion')
                    ->label('Producción')
                    ->required(),

                TextInput::make('desarrollo')
                    ->required(),

                TextInput::make('variedades_cacao')
                    ->label('Variedades de Cacao')
                    ->required(),

                Checkbox::make('es_certificado')
                    ->label('Certificado'),

                FileUpload::make('bosquejo_finca')
                    ->label('Seleccione el bosquejo de la finca')
                    ->disk('public')
                    ->openable()
                    ->image(),

                Placeholder::make('Bosquejo actual de la finca')
                    ->content(function ($record): HtmlString {
                        $imageUrl = $record->bosquejo_finca ?? "";
                        if (strlen($imageUrl) > 0) {
                            return new HtmlString("<img src= '" . $imageUrl . "')");
                        } else {
                            return new HtmlString("Sin imagen");
                        }

                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateDescription(description: "Aun no hay registros para este modulo")
            ->emptyStateHeading(heading: "Sin informacion")
            ->paginated(false)
            ->columns([
                TextColumn::make('nombre_productor')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('codigo')
                    ->searchable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('numero_cedula')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('nombre_finca')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('departamento')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('municipio')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('comunidad')
                    ->weight('medium')
                    ->alignLeft(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Eliminar seleccionados'),
                ])->label('Acciones masivas'),
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
            'index' => Pages\ListGeneralData::route('/'),
            'create' => Pages\CreateGeneralData::route('/create'),
            'edit' => Pages\EditGeneralData::route('/{record}/edit'),
            'records' => Pages\ViewRecords::route('/{record}/records'),
        ];
    }
}
