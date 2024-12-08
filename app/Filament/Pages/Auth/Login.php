<?php

namespace App\Filament\Pages\Auth;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin implements HasForms
{

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label('Iniciar Sesion');
    }
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent()
                        ->label('Correo Electronico'),
                        $this->getPasswordFormComponent()
                            ->label('Contraseña'),
                        $this->getRememberFormComponent()
                            ->label('Recuerdame'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
