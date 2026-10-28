<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->favicon(asset('storage/favicon/favicon.ico'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login(Login::class)
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn() => request()->routeIs('filament.*.auth.login') ? view('filament.login-brand') : ''
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn() => new HtmlString(
                    '<img class="ic-card-logo" src="' . asset('storage/logo/icargologo-dark.png') . '" alt="iCargo">'
                        . '<span class="ic-badge"><span></span>Secure access</span>'
                )
            )
            ->sidebarCollapsibleOnDesktop()        // sidebar can shrink to icons only
            // ->sidebarWidth('18rem')                // wider or narrower sidebar
            ->brandName('iCargoXpress')
            ->brandLogo(asset('storage/logo/icargologo.png'))
            ->darkModeBrandLogo(asset('storage/logo/icargologo-white-plate.png'))
            ->brandLogoHeight('3rem')
            ->brandLogoHeight('2.25rem')                   // the whole panel is dark, like the mockup
            ->colors(['primary' => Color::Amber])
            ->brandLogoHeight('3rem')
            ->sidebarWidth('17rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                //  FilamentInfoWidget::class,
            ])
            ->defaultThemeMode(ThemeMode::Dark)
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
