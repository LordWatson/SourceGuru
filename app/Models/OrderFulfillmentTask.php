<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderFulfillmentTask extends Model
{
    protected $casts = [
        'params' => 'array',
        'output' => 'array'
    ];

    public function dependencies(): HasMany
    {
        return $this->hasMany(TaskDependency::class, 'task_id');
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(FulfillmentStep::class, 'fulfillment_step_id');
    }
}
