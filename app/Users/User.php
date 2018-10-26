<?php

namespace Bookkeeper\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Bookkeeper\Notifications\ResetPasswordNotification;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use SearchableTrait, Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Searchable columns.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name'  => 10,
            'email'      => 10
        ]
    ];

    /**
     * The attributes that may be sorted by.
     *
     * @var array
     */
    public $sortable = ['first_name', 'email', 'created_at'];

    /**
     * Password setter
     *
     * @param string $password
     * @return $this for chaining
     */
    public function setPassword($password)
    {
        $this->attributes['password'] = bcrypt($password);

        return $this;
    }

    /**
     * Static constructor for User
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $user = new static($attributes);

        $user->setPassword($attributes['password']);

        $user->save();

        return $user;
    }

    public function presentAvatar()
    {
        return '<span class="navbar-avatar">' . str_limit($this->first_name, 1, '') .
            str_limit($this->last_name, 1, '') .
            '<img src="http://www.gravatar.com/avatar/' . md5($this->email) . '?d=blank"></span>';
    }

    /**
     * Presenter for full name
     *
     * @return string
     */
    public function presentFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
