<?php


namespace Bookkeeper\Http\Controllers;

use Illuminate\Http\Request;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Users\User;

class UsersController extends BookkeeperController {

    use BasicResource;

    /**
     * Resource names
     *
     * @var string
     */
    protected $modelPath = User::class;
    protected $resourceMultiple = 'users';
    protected $resourceSingular = 'user';
    protected $resourceName = 'User';
    protected $resourceTitleProperty = 'full_name';

    /**
     * Show the form for updating password.
     *
     * @param int $id
     * @return Response
     */
    public function password($id)
    {
        $user = User::findOrFail($id);

        return $this->compileView('users.password', compact('user'), $user->full_name);
    }

    /**
     * Update users password
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $this->resolveRequest('UpdatePassword')->validated();

        $user->setPassword($request->input('password'))->save();

        $this->notify('users.changed_password');

        return redirect()->route('bookkeeper.users.password', $id);
    }

}
