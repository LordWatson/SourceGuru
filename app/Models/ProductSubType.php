<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubType extends Model
{
    // sub types belong to ProductType
    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_sub_type_id');
    }
}
