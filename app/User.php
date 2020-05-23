<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token'
    ];

    /**
     * Default attributes
     *
     * @var array
     */
    protected $attributes = [
        'admin_role' => 'responder' //options are superadmin and responder
    ];

    /**
     * Check if the user is superadmin
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->admin_role === 'superadmin';
    }
}
