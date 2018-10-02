<?php

namespace Bookkeeper\Http\Middleware;


use Carbon\Carbon;
use Closure;
use Bookkeeper\Support\Install\InstallHelper;

class DetermineLocale {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = env('APP_LOCALE');

        if (array_key_exists($locale, InstallHelper::$locales))
        {
            app()->setLocale($locale);

            setlocale(LC_TIME, config('app.full_locales.' . $locale, null));

            Carbon::setLocale($locale);
        }

        return $next($request);
    }

}