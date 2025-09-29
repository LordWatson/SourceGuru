<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskParamMapping extends Model
{
    public function task(): BelongsTo
    {
        return $this->belongsTo(OrderFulfillmentTask::class);
    }

    public function sourceTask(): BelongsTo
    {
        return $this->belongsTo(OrderFulfillmentTask::class, 'source_task_id');
    }
}
