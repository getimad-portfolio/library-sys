<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OwenIt\Auditing\Models\Audit;
use App\Observers\AuditObserver;
use App\Services\TelegramNotificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TelegramNotificationService::class, function ($app) {
            return new TelegramNotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Audit::observe(AuditObserver::class);
    }
}
