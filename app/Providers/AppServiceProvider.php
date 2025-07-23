<?php

namespace App\Providers;

use App\Http\View\Composers\LanguageComposer;
use App\Models\User;
use App\Observers\UserObserver;
use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', LanguageComposer::class);
        Blade::components([
            'Application.components.layouts.pagination' => 'application-pagination',
            'Application.components.layouts.app' => 'app',
            'Application.components.layouts.navbar' => 'navbar',
            'Application.components.layouts.breadcrumb' => 'breadcrumb',
            'Application.components.layouts.feature-list' => 'feature-list',
            'Application.components.layouts.footer' => 'footer',
            'Application.components.layouts.header' => 'header',
            'Application.components.table-toggle'=>'table-toggle' ,

            'Adminpanel.components.app'=>'adminpanel-app',
            'Adminpanel.components.header'=>'adminpanel-header',
            'Adminpanel.components.footer'=>'adminpanel-footer',

        ]);

        User::observe(UserObserver::class);

    }
    
}
