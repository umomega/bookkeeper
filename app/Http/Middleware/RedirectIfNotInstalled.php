<?php


namespace Bookkeeper\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Artisan;

class RedirectIfNotInstalled {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ( ! is_installed())
        {
            if ( ! file_exists(base_path('.env')))
            {
                copy(base_path('.env.example'), base_path('.env'));

                Artisan::call('key:generate', ['--force' => true]);
            }

            if( ! is_request_install())
            {
                return redirect()->route('install-welcome');
            }
        }

        return $next($request);
    }

}
