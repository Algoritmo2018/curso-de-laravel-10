<?php

namespace App\Providers;

use App\Models\Support;
use App\Observers\SupportObserver;
use Illuminate\Support\ServiceProvider;
use App\Repositories\{SupportEloquentORM};
use App\Repositories\Eloquent\ReplySupportRepository;
use App\Repositories\Contracts\{ReplyRepositoryInterface, SupportRepositoryInterface};



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SupportRepositoryInterface::class,
        SupportEloquentORM::class
        );

        $this->app->bind(
            ReplyRepositoryInterface::class,
            ReplySupportRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Support::observe(SupportObserver::class);
    }
}
