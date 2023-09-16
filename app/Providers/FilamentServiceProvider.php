<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\UserResource;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function()
        {
            if(auth()->user()->is_admin === 1)
            // && auth()->user()->hasAnyRole(['super-admin','admin', 'moderator', 'editor'])
            {
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                    ->label('Manage Users')
                    ->url(UserResource::getUrl())
                    ->icon('heroicon-s-users'),
                ]);
            }
        });
    }
}
