<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RenewalRegistrationResource\Pages;
use App\Models\RenewalRegistration;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RenewalRegistrationResource extends Resource
{
    protected static ?string $model = RenewalRegistration::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('numero_plantas_injertada_por_mz')
                    ->label('Numero de plantas injertadas por mz')
                    ->required(),

                DatePicker::make('fecha_injertacion')
                    ->displayFormat('y-m-d')
                    ->format('y-m-d')
                    ->required(),

                TagsInput::make('nombre_clones_injertados')
                    ->label('Nombre de clones injertados')
                    ->separator(',')
                    ->required(),

                TextInput::make('nombre_proveedor')
                    ->label('Nombre del proveedor')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        RenewalRegistration::setGeneralDataId(request('general_data_id'));
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
                TextColumn::make('fecha_injertacion')
                    ->label('Fecha de injertacion')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('numero_plantas_injertada_por_mz')
                    ->label('Numero de plantas injertadas por mz')
                    ->weight('medium')
                    ->alignLeft(),

                Tables\Columns\TagsColumn::make('nombre_clones_injertados')
                    ->label('Nombre de clones injertados')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('nombre_proveedor')
                    ->label('Nombre del proveedor')
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
            'index' => Pages\ListRenewalRegistrations::route('/'),
            'create' => Pages\CreateRenewalRegistration::route('/create/{general_data_id}'),
            'edit' => Pages\EditRenewalRegistration::route('/{record}/edit/{general_data_id}'),
        ];
    }
}
