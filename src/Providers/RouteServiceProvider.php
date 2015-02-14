<?php
namespace TypiCMS\Modules\Contacts\Providers;

use Config;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Contacts\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('contacts', 'TypiCMS\Modules\Contacts\Models\Contact');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function($router) {
            /**
             * Front office routes
             */
            $router->group(['before' => 'visitor.publicAccess'], function ($router) {
                $routes = app('TypiCMS.routes');
                foreach (Config::get('translatable.locales') as $lang) {
                    if (isset($routes['contacts'][$lang])) {
                        $uri = $routes['contacts'][$lang];
                    } else {
                        $uri = 'contacts';
                        if (Config::get('app.fallback_locale') != $lang || Config::get('app.main_locale_in_url')) {
                            $uri = $lang . '/' . $uri;
                        }
                    }
                    $router->get($uri, array('as' => $lang.'.contacts', 'uses' => 'PublicController@index'));
                    $router->get($uri.'/{slug}', array('as' => $lang.'.contacts.slug', 'uses' => 'PublicController@show'));
                }
            });

            /**
             * Admin routes
             */
            $router->resource('admin/contacts', 'AdminController');

            /**
             * API routes
             */
            $router->resource('api/contacts', 'ApiController');
        });
    }

}