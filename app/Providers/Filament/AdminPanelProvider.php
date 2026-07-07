<?php

namespace App\Providers\Filament;

use Awcodes\Botly\BotlyPlugin;
use Benriadh1\FilamentTranslationManager\BenriadhFilamentTranslationManagerPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Prunacatalin\FilamentLocaleSwitcher\Http\Middleware\ApplyLocale;
use Prunacatalin\FilamentLocaleSwitcher\LocaleSwitchPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->colors([
                'primary' => '#b90000',
            ])
            ->brandName('PT Putra Setia Sukses Bersama')
            ->brandLogo(fn () => view('filament.admin.logo'))
            ->brandLogoHeight('2.5rem')
            ->homeUrl(fn (): string => route('home'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->navigationGroups([
                'Website',
                'Produk',
                'Project',
                'Artikel',
                'Pengaturan',
            ])
            ->plugins([
                BotlyPlugin::make(),
                BenriadhFilamentTranslationManagerPlugin::make(),
                LocaleSwitchPlugin::make()
                    ->locales(['id', 'en', 'zh']),
                // FilamentLanguageSwitcherPlugin::make()
                //     ->locales(['id', 'en', 'zh'])
                //     ->rememberLocale(days: 30)
                //     ->showOnAuthPages(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
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
                ApplyLocale::class,

            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
