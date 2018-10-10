<?php


namespace Bookkeeper\Http\Controllers;



use Illuminate\Http\Request;

abstract class BookkeeperController extends Controller {

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
        $parameters['pageTitle'] = ($title ?: trans($view));

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

}
