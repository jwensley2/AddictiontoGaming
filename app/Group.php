<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{

    /**
     * Return the groups users
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('User');
    }

    /**
     * Return the group permissions
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'group_permissions')->withPivot('access');
    }

    /**
     * Check if group has a permission
     *
     * @param bool $key The key for the permission
     * @return bool
     */
    public function hasPermission($key)
    {

        $hasPermission = $this->permissions()
            ->where('key', $key)
            ->where('access', 1)
            ->first();

        if ($hasPermission) {
            return true;
        }

        return false;
    }
}