<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PackageOption extends Model
{
    protected $fillable = [
        'package_id',
        'name',
        'description',
        'sort_order',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'package_option_products')
            ->withPivot('unit_buy_price', 'unit_sell_price')
            ->withTimestamps();
    }
}
