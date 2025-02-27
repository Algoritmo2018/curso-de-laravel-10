<?php

namespace App\Providers;

use App\Models\Support;
use App\Observers\SupportObserver;
use Illuminate\Support\ServiceProvider;
use App\Repositories\{PermissionEloquentORM, RoleEloquentORM, SupportEloquentORM, UserEloquentORM};
use App\Repositories\Eloquent\ReplySupportRepository;
use App\Repositories\Contracts\{PermissionRepositoryInterface, ReplyRepositoryInterface, RoleRepositoryInterface, SupportRepositoryInterface, UserRepositoryInterface};
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            SupportRepositoryInterface::class,
            SupportEloquentORM::class
        );
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleEloquentORM::class
        );
        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionEloquentORM::class
        );

        $this->app->bind(
            ReplyRepositoryInterface::class,
            ReplySupportRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('superadmin') ? true : null;
        });
        Support::observe(SupportObserver::class);
    }
}
