<?php

namespace App\Actions\Company;

use App\Actions\CreateAction;
use App\Models\Company;

class CreateCompanyAction extends CreateAction
{
    protected function createModelInstance(array $data): Company
    {
        return Company::create($data);
    }
}
