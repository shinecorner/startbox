<?php

namespace App\Providers;

use Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $admin_namespace = 'App\Http\Controllers\Admin';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapClientRoutes();
        $this->mapAdminRoutes();
        $this->mapGuestRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapGuestRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapClientRoutes()
    {
        Route::prefix('client/api/v1')
             ->middleware('api')
             ->namespace("$this->namespace\Client")
             ->group(base_path('routes/client/api.php'));

        Route::prefix('client/api/v1')
             ->middleware('api-guest')
             ->namespace("$this->namespace\Client")
             ->group(base_path('routes/client/guest.php'));
    }

    public function mapAdminRoutes()
    {
        Route::domain(config('app.base_api_url'))->group(function () {
            Route::prefix('admin')
                ->namespace($this->admin_namespace)
                ->group(base_path('routes/admin/api-admin.php'));            
        });

        Route::middleware('web')
            ->prefix('admin')
            ->namespace($this->admin_namespace)
            ->group(base_path('routes/admin/web-admin.php'));
    }
}
