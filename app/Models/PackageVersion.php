<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageVersion extends Model
{
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function versionProducts(): HasMany
    {
        return $this->hasMany(PackageVersionProduct::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'package_version_products')
            ->withPivot(['unit_buy_price', 'unit_sell_price'])
            ->wherePivot('package_id', $this->package_id)
            ->withTimestamps();
    }
}
