<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The dataframe equivalent.
     *
     * @var array
     */
    static $fieldName = 0;
    static $fieldType = 1;
    static $fieldValues = 2;
    static $fieldOnForm = 3;
    static $fieldRequiredOnForm = 4;
    static $fieldOnIndex = 5;
    static $fieldOnFilter = 6;
    static $fieldsOnDatabase = [
        ['name', 'text', '', true, true, true, false],
        ['email', 'email', '', true, true, true, false],
        ['isAdmin', 'checkbox', '', true, false, true, false],
        ['active', 'checkbox', '', true, false, true, false],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ulcn_uid', 'name', 'email', 'password', 'isAdmin', 'active'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Checks if user is Admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return (\Auth::check() && $this->isAdmin == TRUE);
    }

    /**
     * Returns the url path for the instance.
     *
     * @param  \App\User  $user
     * @return url path
     */
    public function path()
    {
        return route('users.show', $this);
    }
}
