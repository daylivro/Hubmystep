<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Models\Partner;
use App\Models\FaqCatalog;
use App\Models\Permission;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Models\PartnerCategory;
use App\Observers\UserObserver;
use App\Policies\PartnerPolicy;
use App\Observers\PartnerObserver;
use App\Policies\FaqCatalogPolicy;
use App\Policies\PermissionPolicy;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Gate;
use App\Policies\PartnerCategoryPolicy;
use Essa\APIToolKit\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Contracts\Debug\ExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExceptionHandler::class, Handler::class); // add this line
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(FaqCatalog::class, FaqCatalogPolicy::class);
        Gate::policy(Partner::class, PartnerPolicy::class);
        Gate::policy(PartnerCategory::class, PartnerCategoryPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);

        \App\Models\User::observe(UserObserver::class);
        Partner::observe(PartnerObserver::class);

        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'secondary' => '#54308E'
        ]);
    }
}
