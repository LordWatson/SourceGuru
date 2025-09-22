<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFulfillmentStep extends Model
{
    protected $casts = [
        'params' => 'array'
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(FulfillmentStep::class, 'fulfillment_step_id');
    }
}
