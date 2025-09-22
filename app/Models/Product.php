<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    // products belong to a ProductType
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function fulfillmentSteps(): HasMany
    {
        return $this->hasMany(ProductFulfillmentStep::class)->orderBy('step_order');
    }

    // products belong to a ProductSubType
    public function productSubType(): BelongsTo
    {
        return $this->belongsTo(ProductSubType::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_products')
            ->withTimestamps();
    }

    public function packageVersions(): BelongsToMany
    {
        return $this->belongsToMany(PackageVersion::class, 'package_version_products')
            ->withPivot(['unit_buy_price', 'unit_sell_price'])
            ->withTimestamps();
    }
}
