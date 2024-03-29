<?php

namespace ikepu_tp\FileLibrary;

use ikepu_tp\FileLibrary\app\Models\File;
use ikepu_tp\FileLibrary\app\Observers\FileObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class FileLibraryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/file-library.php', 'file-library');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
        $this->defineRoutes();
        $this->loadTranslationsFrom(__DIR__ . "/resources/lang", "FileLibrary");
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . "/resources/views", "FileLibrary");
        Paginator::useBootstrap();
        Blade::componentNamespace("ikepu_tp\\resources\\views\\components", "FileLibrary");

        File::observe(FileObserver::class);
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {
        if (!$this->app->runningInConsole()) return;

        $this->publishes([
            __DIR__ . '/config/file-library.php' => base_path('config/file-library.php'),
        ], 'FileLibrary-config');


        $this->publishMigration();
        $this->publishView();
        $this->publishLang();
        $this->publishAsset();
    }

    private function publishMigration(): void
    {
        $migrations = [];
        foreach ($migrations as $migration) {
            $this->publishes([
                __DIR__ . "/database/migrations/{$migration}" => database_path(
                    "migrations/{$migration}"
                ),
            ], 'migrations');
        }
    }

    private function publishView(): void
    {
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/FileLibrary'),
        ], 'FileLibrary-views');
    }

    private function publishLang(): void
    {
        $this->publishes([
            __DIR__ . '/resources/lang' => resource_path('lang/vendor/FileLibrary'),
        ], 'FileLibrary-lang');
    }

    private function publishAsset(): void
    {
        $this->publishes([], 'FileLibrary-assets');
    }

    /**
     * Define the routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . "/routes/route.php");
    }
}