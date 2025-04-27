<?php

namespace App\Actions;

use App\Actions\ActivityLog\CreateActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class CreateAction
{
    public function __construct(protected CreateActivityLog $createActivityLog)
    {
        //
    }

    /**
     * Execute the create operation.
     */
    public function execute(array $data): array
    {
        try {
            // begin a db transaction
            DB::beginTransaction();

            // create the new model record
            $model = $this->createModelInstance($data);

            // log the creation success
            $this->logActivity(
                model: $model,
                statusCode: 201
            );

            // commit the transaction
            DB::commit();

        } catch (\Exception $e) {
            // undo the db transaction
            DB::rollBack();

            // log the failure
            $this->logActivity(
                model: null,
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
        int $statusCode,
        ?string $message = null
    ): void {
        $activityLog = [
            'model' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'event' => 'create',
            'changes' => $model ? json_encode($model->getAttributes()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }

    /**
     * Provide the new model instance to create.
     */
    abstract protected function createModelInstance(array $data): Model;
}
