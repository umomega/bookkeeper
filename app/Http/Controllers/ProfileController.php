<?php

namespace Bookkeeper\Http\Controllers;


use Illuminate\Http\Request;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Users\User;

class ProfileController extends BookkeeperController {

    /**
     * Resource names
     *
     * @var string
     */
    protected $resourceName = 'Profile';

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $profile = $this->getProfile();

        return $this->compileView('profile.edit', compact('profile'), trans('users.update_profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $this->resolveRequest('Update')->validated();

        $profile->update($validated);

        $this->notify('users.updated_profile');

        return redirect()->route('bookkeeper.profile.edit');
    }

    /**
     * Show the form for updating password.
     *
     * @return Response
     */
    public function password()
    {
        $profile = $this->getProfile();

        return $this->compileView('profile.password', compact('profile'), trans('users.change_password'));
    }

    /**
     * Update users password
     *
     * @param Request $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $profile = $this->getProfile();

        $validated = $this->resolveRequest('UpdatePassword')->validated();

        $profile->setPassword($request->input('password'))->save();

        $this->notify('users.changed_password');

        return redirect()->route('bookkeeper.profile.password');
    }

    /**
     * Returns the currently logged in user
     *
     * @return User
     */
    protected function getProfile()
    {
        return auth()->user();
    }

}
