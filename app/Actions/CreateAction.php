<?php

namespace App\Actions;

use App\Actions\ActivityLog\CreateActivityLog;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class CreateAction
{
    public function __construct
    (
        protected CreateActivityLog $createActivityLog
    ){
        //
    }

    public function execute(array $data, string $message = 'Record created successfully'): array
    {
        try{
            // create the record
            $model = $this->handleTransaction(
                fn() => $this->createModelInstance($data)
            );

            // log the creation
            $this->logActivity(model: $model, statusCode: 201, event: 'create', message: $message);

            return $this->successResponse($model);
        }catch (Exception $e){
            // log the failed creation
            $this->logActivity(model: null, statusCode: 500, event: 'create', message: $e->getMessage());

            return $this->errorResponse($e->getMessage());
        }
    }

    protected function logActivity
    (
        ?Model $model,
        int $statusCode,
        string $event,
        ?string $message = null
    ): void
    {

        $activityLog = [
            'model' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'event' => $event,
            'changes' => $model ? json_encode($model->getAttributes()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }

    /**
     * @throws Exception
     */
    protected function handleTransaction(callable $callback): mixed
    {
        // create the record
        try{
            DB::beginTransaction();

            $result = $callback();

            DB::commit();

            return $result;
        }catch(Exception $e){
            DB::rollBack();

            throw $e;
        }
    }

    protected function successResponse(Model $model): array
    {
        return [
            strtolower(class_basename($model)) => $model->fresh(),
            'success' => true,
        ];
    }

    protected function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }

    abstract protected function createModelInstance(array $data): Model;
}
