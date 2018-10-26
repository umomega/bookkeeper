<?php


namespace Bookkeeper\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Bookkeeper\Support\Install\InstallHelper;
use Illuminate\Http\Request;

class SettingsController extends BookkeeperController {

    /**
     * Resource names
     *
     * @var string
     */
    protected $resourceName = 'Settings';

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = [
            'APP_LOCALE' => config('app.locale'),
            'DEFAULT_CURRENCY' => config('app.default_currency')
        ];

        return $this->compileView('settings.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     * @param InstallHelper $helper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InstallHelper $helper)
    {
        $validated = $this->resolveRequest('Update')->validated();

        $helper->setEnvVariable('APP_LOCALE', $request->input('APP_LOCALE'), 'app.locale');
        $helper->setEnvVariable('DEFAULT_CURRENCY', $request->input('DEFAULT_CURRENCY'), 'app.default_currency');

        // Forget the currency rates cache since default account may have been changed
        Cache::forget('bookkeeper.currency.rates');

        // Optimize the config
        Artisan::call('optimize');

        return redirect()->route('bookkeeper.settings.flush');
    }

    /**
     * Optimizes the app after settings change
     *
     * @return \Illuminate\Http\Response
     */
    public function flush()
    {
        $this->notify('settings.edited');

        return redirect()->route('bookkeeper.settings.edit');
    }

}
