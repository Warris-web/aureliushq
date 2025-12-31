<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


public function boot()
{
// Force Laravel to use the current domain (ngrok or localhost)
URL::forceRootUrl(request()->getSchemeAndHttpHost());

// Ensure HTTPS is enforced when using ngrok
if (str_contains(request()->getHost(), 'ngrok')) {
    URL::forceScheme('https');
}
Schema::defaultStringLength(191);

}


}
