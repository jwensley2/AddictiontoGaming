<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    public function users()
    {
        return $this->belongsToMany('User', 'user_permissions');
    }

    public function groups()
    {
        return $this->belongsToMany('Group', 'group_permissions');
    }
}