<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsersResource\Pages;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Gestión de usuarios';

    protected static ?string $navigationLabel = 'Gestión de usuarios';

    public static function canAccess(): bool
    {
        return Filament::auth()->user()->rol === 'Administrador';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->required(),

                TextInput::make('codigo')
                    ->label('Codigo')
                    ->required(),

                TextInput::make('numero_cedula')
                    ->label('Numero de Cedula')
                    ->required(),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->type('password')
                    ->required(),

                Select::make('rol')
                    ->options([
                        'Administrador' => 'Administrador',
                        'Usuario' => 'Usuario',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('codigo')
                    ->label('Codigo')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('numero_cedula')
                    ->label('Numero de Cedula')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('rol')
                    ->label('Rol')
                    ->weight('medium')
                    ->alignLeft(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }
}
