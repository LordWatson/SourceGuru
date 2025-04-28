<?php

namespace App\Actions;

use App\Actions\ActivityLog\CreateActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class UpdateAction
{
    public function __construct(protected CreateActivityLog $createActivityLog)
    {
        //
    }

    /**
     * Execute the update operation.
     */
    public function execute(array $data, string $message = 'Record updated successfully'): array
    {
        // get the record
        $model = $this->getModelInstance($data['id']);

        try {
            // begin a db transaction
            DB::beginTransaction();

            // get the original data (used for the activity log)
            $originalData = $model->getOriginal();

            // remove the id from the update array
            unset($data['id']);

            // update the record
            $model->update($data);

            // log the success
            $this->logActivity(
                model: $model,
                originalData: $originalData,
                statusCode: 201,
                message: $message
            );

            // commit the changes
            DB::commit();
        } catch (\Exception $e) {
            // undo the db transaction
            DB::rollBack();

            // log the failure
            $this->logActivity(
                model: $model,
                originalData: $model->getOriginal() ?? null,
                statusCode: 500,
                message: $e->getMessage()
            );

            // return a failed message
            return [
                'success' => false
            ];
        }

        // success !!
        return [
            strtolower(class_basename($model)) => $model->fresh(),
            'success' => true,
        ];
    }

    /**
     * Log Activity
     */
    protected function logActivity(
        ?Model $model,
        ?array $originalData,
        int $statusCode,
        ?string $message = null
    ): void {
        $activityLog = [
            'model' => get_class($model),
            'model_id' => $model?->id,
            'event' => 'update',
            'original' => $originalData ? json_encode($originalData) : null,
            'changes' => $model ? json_encode($model->getChanges()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }

    /**
     * Provide the specific model instance to work with.
     */
    abstract protected function getModelInstance(int $id): Model;
}
