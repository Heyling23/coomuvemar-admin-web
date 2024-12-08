<?php

namespace App\Filament\Pages\Auth;
use Filament\Actions\Action;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{

    public function getRegisterFormAction(): Action
    {
        return parent::getRegisterFormAction()
            ->label('Registrarse');
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent()
                            ->label('Nombre de usuario'),
                        $this->getEmailFormComponent()
                            ->label('Correo electronico'),
                        $this->getPasswordFormComponent()
                            ->label('Contraseña'),
                        $this->getPasswordConfirmationFormComponent()
                            ->label('Confirma tu contraseña'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
