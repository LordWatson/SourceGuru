<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFulfillmentStepDependency extends Model
{
    protected $table = 'product_step_dependencies';

    public function step(): BelongsTo
    {
        return $this->belongsTo(ProductFulfillmentStep::class, 'product_fulfillment_step_id');
    }

    public function dependsOn(): BelongsTo
    {
        return $this->belongsTo(ProductFulfillmentStep::class, 'depends_on_step_id');
    }
}
