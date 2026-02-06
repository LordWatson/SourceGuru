<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItem extends Model
{
    protected $casts = [
        'squashed_products' => 'array',
        'selected_options' => 'array',
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'type_id');
    }

    /*
     * populates the 'total' column whenever a quote item is saved
     * */
    protected static function booted(): void
    {
        static::saving(function ($item) {
            $item->total_sell_price = $item->quantity * $item->unit_sell_price;
            $item->total_buy_price = $item->quantity * $item->unit_buy_price;
        });
    }
}
