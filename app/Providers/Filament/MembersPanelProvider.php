<?php

namespace App\Providers\Filament;

use App\Filament\Members\Resources\CustomerResource;
use App\Filament\Members\Resources\CustomerResource\Pages\Profile;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Customer;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class MembersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('members')
            ->path('members')
            ->login()
            ->authGuard('members')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverPages(in: app_path('Filament/Members/Pages'), for: 'App\\Filament\\Members\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Members/Widgets'), for: 'App\\Filament\\Members\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class . ':members',
            ]);
    }
}
