<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageVersionProduct extends Model
{
    protected $fillable = [
        'package_version_id',
        'package_id',
        'product_id',
        'unit_buy_price',
        'unit_sell_price',
    ];

    protected $casts = [
        'unit_buy_price' => 'decimal:2',
        'unit_sell_price' => 'decimal:2',
    ];

    public function version(): BelongsTo
    {
        return $this->belongsTo(PackageVersion::class, 'package_version_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
