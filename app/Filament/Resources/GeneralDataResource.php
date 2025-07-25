<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralDataResource\Pages;
use App\Models\BaseURL;
use App\Models\GeneralData;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Termwind\Enums\Color;

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
                    ->default(request()->user()['name'])
                    ->readOnly()
                    ->required(),

                TextInput::make('codigo')
                    ->label('Codigo')
                    ->default(request()->user()['codigo'])
                    ->readOnly()
                    ->required(),

                TextInput::make('numero_cedula')
                    ->label('Cédula')
                    ->default(request()->user()['numero_cedula'])
                    ->readOnly()
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
                    ->numeric()
                    ->required(),

                TextInput::make('departamento')
                    ->required(),

                TextInput::make('municipio')
                    ->required(),

                TextInput::make('comunidad')
                    ->required(),

                TextInput::make('area_cacao')
                    ->label('Área del cacao')
                    ->required()
                    ->numeric()
                    ->lt('area_total_finca')
                    ->validationMessages([
                        'lt' => 'Área del cacao no puede ser mayor al Área total de la finca',
                    ]),

                TextInput::make('produccion')
                    ->label('Producción')
                    ->required(),

                TextInput::make('desarrollo')
                    ->lt('produccion')
                    ->validationMessages([
                        'lt' => 'El desarrollo no puede ser mayor a la producción',
                    ])
                    ->required(),

                TextInput::make('variedades_cacao')
                    ->label('Variedades de Cacao')
                    ->required(),

                Checkbox::make('es_certificado')
                    ->hidden(true),

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
                Filter::make('certificados')
                    ->label('Fincas con certificaciones')
                    ->query(fn (Builder $query): Builder => $query->where('es_certificado', true)),

                Filter::make('no_certificado')
                    ->label('Fincas sin certificaciones')
                    ->query(fn (Builder $query): Builder => $query->where('es_certificado', false)),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportar_certificados')
                    ->label('Exportar con certificaciones')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->openUrlInNewTab()
                    ->action(function () {
                        $certificados = GeneralData::where('es_certificado', true)->get();

                        return response()->streamDownload(function () use ($certificados) {
                            echo Pdf::loadHTML(
                                Blade::render('pdf', ['records' => $certificados])
                            )->stream();
                        }, 'certificados.pdf');
                    }),

                Tables\Actions\Action::make('exportar_no_certificados')
                    ->label('Exportar sin certificaciones')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->openUrlInNewTab()
                    ->action(function () {
                        $certificados = GeneralData::where('es_certificado', false)->get();

                        return response()->streamDownload(function () use ($certificados) {
                            echo Pdf::loadHTML(
                                Blade::render('pdf', ['records' => $certificados])
                            )->stream();
                        }, 'no-certificados.pdf');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar'),

                Tables\Actions\Action::make('edit')
                    ->icon(fn(GeneralData $record) => ($record->es_certificado) ? 'heroicon-s-x-circle' : 'heroicon-s-check-circle')
                    ->color(Color::GREEN_900)
                    ->label(fn(GeneralData $record) => ($record->es_certificado) ? "Desaprobar" : "Aprobar")
                    ->action(function (GeneralData $record) {
                        $record->es_certificado = !$record->es_certificado;
                        $url = BaseURL::$BASE_URL . "general-data/change-certification-status/" . $record->id;
                        $response = Http::put(
                            url: $url,
                            data: $record->getAttributes()['es_certificado'] ? ['es_certificado' => true] : ['es_certificado' => false]
                        )->json();
                        if ($response['status'] === false) {
                            Notification::make()
                                ->title("Failed to update record: " . $response['message'])
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title("Estado actualizado")
                                ->success()
                                ->send();
                        }
                        $record->save();
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('Exportar seleccionados')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->openUrlInNewTab()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                echo Pdf::loadHTML(
                                    Blade::render('pdf', ['records' => $records])
                                )->stream();
                            }, 'datos-generales.pdf');
                        }),
                ])->label('Acciones'),
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
