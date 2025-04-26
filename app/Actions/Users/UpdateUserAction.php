<?php

namespace App\Actions\Users;

use App\Actions\UpdateAction;
use App\Models\User;

class UpdateUserAction extends UpdateAction
{
    protected function getModelInstance(int $id): User
    {
        return User::findOrFail($id);
    }
}
