<?php

namespace App\Actions\Users;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CreateActivityLog $createActivityLog)
    {
        //
    }

    public function execute(array $data) : User
    {
        try{
            DB::beginTransaction();

            // get the user
            $user = User::find($data['id']);

            // remove the id from the data array
            unset($data['id']);

            // update the fields
            $user->update($data);

            $activityLog = [
                'model' => User::class,
                'model_id' => $user->id,
                'event' => 'updated',
                'original' => json_encode($user->getOriginal()),
                'changes' => json_encode($user->getChanges()),
                'status_code' => 201,
            ];

            $this->createActivityLog->execute($activityLog);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();

            throw $e;
        }

        return $user->fresh();;
    }
}
