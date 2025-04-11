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

    public function execute(array $data): array
    {
        try {
            DB::beginTransaction();

            // get the user.
            $user = User::find($data['id']);

            // remove the id from the data array.
            unset($data['id']);

            // update the fields.
            $originalData = $user->getOriginal();
            $user->update($data);

            // log the update activity.
            $this->logActivity($user, $originalData, 201);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // log the failed update.
            $originalData = $user->getOriginal() ?? null;
            $this->logActivity($user, $originalData, 500, $e->getMessage());

            return [
                'success' => false
            ];
        }

        return [
            'user' => $user->fresh(),
            'success' => true,
        ];
    }

    /**
     * Log User Activity.
     */
    private function logActivity(
        ?User $user,
        ?array $originalData,
        int $statusCode,
        ?string $message = null
    ): void {
        $activityLog = [
            'model' => User::class,
            'model_id' => $user?->id,
            'event' => 'updated',
            'original' => $originalData ? json_encode($originalData) : null,
            'changes' => $user ? json_encode($user->getChanges()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }
}
