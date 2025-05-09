<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    public function quote(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Quote::class);
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
