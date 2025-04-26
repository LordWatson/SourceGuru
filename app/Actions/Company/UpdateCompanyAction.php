<?php

namespace App\Actions\Company;

use App\Actions\UpdateAction;
use App\Models\Company;

class UpdateCompanyAction extends UpdateAction
{
    protected function getModelInstance(int $id): Company
    {
        return Company::findOrFail($id);
    }
}
