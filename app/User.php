<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Validation Rules
     */
    public static $rules = array(
        'username' => 'required|alpha_dash|between:3,50|unique:users,username',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    );

    /**
     * Rules for changing password
     */
    public static $changePasswordRules = array(
        'password' => 'required|min:6|confirmed',
    );

    /**
     * Rules for updating profile
     */
    public static $updateProfileRules = array(
        'username' => 'required|alpha_dash|between:3,50|unique:users,username',
        'email'    => 'required|email|unique:users,email',
    );

    /**
     * Rules for updating profile
     */
    public static $updateRules = array(
        'username' => 'required|alpha_dash|between:3,50|unique:users,username',
        'email'    => 'required|email|unique:users,email',
        'group_id' => 'exists:groups,id',
    );

    /**
     * Return the group relationship
     *
     * @return Relationship
     */
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'user_permissions')->withPivot('access');
    }

    /**
     * Check if user has a permission
     *
     * @param type $key The key for the permission
     * @return bool
     */
    public function hasPermission($key, $checkFounder = true)
    {
        $user_access  = 0;
        $group_access = 0;

        if (!\Auth::check()) {
            return false;
        }

        if ($this->founder == true AND $checkFounder === true) {
            return true;
        }

        $key = strtoupper($key);

        // Check if the user has permission
        foreach ($this->permissions AS $permission) {
            if ($permission->key == $key) {
                $user_access = $permission->pivot->access;
                break;
            }
        }

        // Check if the user's group has permission
        if ($this->group) {
            foreach ($this->group->permissions AS $permission) {
                if ($permission->key == $key) {
                    $group_access = $permission->pivot->access;
                    break;
                }
            }
        }

        return (($user_access + $group_access) > 0);
    }
}
