<?php

namespace App\Actions\Company;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateCompanyAction
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

            // create the company
            $company = Company::create($data);

            // log the update activity
            $this->logActivity(statusCode: 201, message: 'Company created successfully', company: $company);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // log the failed creation
            $this->logActivity(statusCode: 500, message: $e->getMessage());

            return [
                'success' => false
            ];
        }

        return [
            'company' => $company,
            'success' => true,
        ];
    }

    /**
     * Log User Activity.
     */
    private function logActivity(
        int $statusCode,
        ?string $message,
        ?Company $company = null
    ): void {
        $activityLog = [
            'model' => Company::class,
            'model_id' => $company?->id ?? null,
            'event' => 'create',
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }
}
