<?php

namespace App\Actions\Packages;

use App\Actions\CreateAction;
use App\Models\Package;

class CreatePackageAction extends CreateAction
{
    protected function createModelInstance(array $data): Package
    {
        return Package::create($data);
    }
}
