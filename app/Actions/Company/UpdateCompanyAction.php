<?php

namespace App\Actions\Company;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateCompanyAction
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
        // get the company
        $company = Company::findOrFail($data['id']);

        try {
            DB::beginTransaction();

            // remove the id from the data array
            unset($data['id']);

            // update the fields
            $originalData = $company->getOriginal();
            $company->update($data);

            // log the update activity
            $this->logActivity(company: $company, originalData: $originalData, statusCode: 201);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // log the failed update
            $originalData = $company->getOriginal() ?? null;
            $this->logActivity(company: $company, originalData:  $originalData, statusCode: 500, message:  $e->getMessage());

            return [
                'success' => false
            ];
        }

        return [
            'company' => $company->fresh(),
            'success' => true,
        ];
    }

    /**
     * Log User Activity.
     */
    private function logActivity(
        ?Company $company,
        ?array $originalData,
        int $statusCode,
        ?string $message = null
    ): void {
        $activityLog = [
            'model' => Company::class,
            'model_id' => $company?->id,
            'event' => 'update',
            'original' => $originalData ? json_encode($originalData) : null,
            'changes' => $company ? json_encode($company->getChanges()) : null,
            'status_code' => $statusCode,
            'message' => $message,
        ];

        $this->createActivityLog->execute($activityLog);
    }
}
