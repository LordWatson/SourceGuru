<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductFulfillmentStep extends Model
{
    protected $casts = [
        'params' => 'array'
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(FulfillmentStep::class, 'fulfillment_step_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(ProductFulfillmentStepDependency::class, 'product_fulfillment_step_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(ProductFulfillmentStepDependency::class, 'depends_on_step_id');
    }
}
