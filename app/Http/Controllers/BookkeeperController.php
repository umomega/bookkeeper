<?php

namespace Bookkeeper\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

abstract class BookkeeperController extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Compiles view for display
     *
     * @param string $view
     * @param array $parameters
     * @param string $title
     * @return view
     */
    protected function compileView($view, array $parameters = [], $title = null)
    {
        $parameters['pageTitle'] = ($title ?: __($view));

        return view($view, $parameters);
    }

    /**
     * Flash and chronicle notification
     *
     * @param string $flash
     * @param string $type
     */
    public function notify($flash = null, $type = 'success')
    {
        if ( ! is_null($flash))
        {
            flash()->{$type}(trans($flash));
        }
    }

    /**
     * Resolves a request from the app
     *
     * @param string $name
     * @return Request
     */
    protected function resolveRequest($name)
    {
        return app('Bookkeeper\Http\Requests\\' . $this->resourceName . $name);
    }

}
