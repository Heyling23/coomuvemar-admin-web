<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \Filament\Http\Responses\Auth\LoginResponse::class,
            LoginResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
            fn() : View => view()->make('filament.pages.auth.header-login')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE,
            fn() : View => view()->make('filament.pages.auth.header-login')
        );
    }
}
