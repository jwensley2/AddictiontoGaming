<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
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
        return $this->hasMany(User::class);
    }

    /**
     * Return the group permissions
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'group_permissions')->withPivot('access');
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
