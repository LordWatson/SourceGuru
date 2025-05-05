<?php

namespace App\Actions\Proposals;

use App\Actions\CreateAction;
use App\Models\Proposal;

class CreateProposalAction extends CreateAction
{
    protected function createModelInstance(array $data): Proposal
    {
        return Proposal::create($data);
    }
}
