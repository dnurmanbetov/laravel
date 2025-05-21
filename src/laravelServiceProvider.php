<?php

namespace dnurmanbetov\laravel;

use Illuminate\Support\ServiceProvider;

class laravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Публикация миграций
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Публикация конфигураций
        $this->publishes([
            __DIR__ . '/config/base-package.php' => config_path('base-package.php'),
        ], 'config');

        // Публикация публичных ресурсов
        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/base-package'),
        ], 'public');

        // Публикация шаблонов
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/base-package'),
        ], 'views');

        // Загрузка маршрутов, если нужно
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        // Загрузка шаблонов Blade
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'base-package');

        // Регистрация команд
        if ($this->app->runningInConsole()) {
            $this->commands([
                \dnurmanbetov\laravel\Console\Commands\YourCommand::class,
            ]);
        }
    }

    public function register()
    {
        // Регистрация сервисов, если нужно
        $this->app->singleton(YourService::class, function ($app) {
            return new YourService();
        });

        // Объединяем конфигурацию
        $this->mergeConfigFrom(__DIR__ . '/config/base-package.php', 'base-package');
    }
}