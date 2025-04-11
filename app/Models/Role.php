<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
