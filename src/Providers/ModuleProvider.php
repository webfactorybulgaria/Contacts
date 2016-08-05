<?php

namespace TypiCMS\Modules\Contacts\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Contacts\Custom\Events\EventHandler;
use TypiCMS\Modules\Contacts\Custom\Models\Contact;
use TypiCMS\Modules\Contacts\Custom\Repositories\CacheDecorator;
use TypiCMS\Modules\Contacts\Custom\Repositories\EloquentContact;
use TypiCMS\Modules\Core\Custom\Facades\TypiCMS;
use TypiCMS\Modules\Core\Custom\Observers\FileObserver;
use TypiCMS\Modules\Core\Custom\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.contacts'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['contacts' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'contacts');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'contacts');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/contacts'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        // Honeypot facade
        AliasLoader::getInstance()->alias(
            'Honeypot',
            'Msurguy\Honeypot\HoneypotFacade'
        );

        // Observers
        Contact::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Subscribe to events class
         */
        $app->events->subscribe(new EventHandler());

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Contacts\Custom\Providers\RouteServiceProvider');

        /*
         * Register Honeypot
         */
        $app->register('Msurguy\Honeypot\HoneypotServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Contacts\Custom\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('contacts::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('contacts');
        });

        $app->bind('TypiCMS\Modules\Contacts\Custom\Repositories\ContactInterface', function (Application $app) {
            $repository = new EloquentContact(new Contact());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'contacts', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
