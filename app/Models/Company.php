<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function accountManager()
    {
        return $this->belongsTo(
            User::class,
            foreignKey: 'account_manager_id',
        );
    }
}
