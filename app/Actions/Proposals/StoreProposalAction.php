<?php

namespace App\Actions\Proposals;

use App\Models\ActivityLog;
use App\Models\Proposal;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreProposalAction
{
    public function execute(UploadedFile $file, string $quoteId): array
    {
        if ($file->isValid()) {
            try{
                // get the filename
                $fileName = $file->getClientOriginalName();

                // get storage path
                $storagePath = "proposals/{$quoteId}/{$fileName}";

                // store the file
                $file->storeAs("proposals/{$quoteId}", $fileName, 'public');

                // return stored location
                return [
                    'success' => true,
                    'url' => Storage::url($storagePath),
                ];
            }catch(\Exception $e){
                return [
                    'success' => false,
                ];
            }
        }
    }
}
