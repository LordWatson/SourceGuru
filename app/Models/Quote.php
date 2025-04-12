<?php

namespace App\Models;

use App\Enums\QuoteStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $casts = [
        'expired_date' => 'date',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    // sum the unit_sell_price of all associated products
    public function getTotalSellPriceAttribute(): float
    {
        return $this->products->sum('unit_sell_price');
    }

    // sum the unit_buy_price of all associated products
    public function getTotalBuyPriceAttribute(): float
    {
        return $this->products->sum('unit_buy_price');
    }

    // sum the revenue by subtracting the buy price from the sell price
    public function getRevenueAttribute(): float
    {
        return $this->getTotalSellPriceAttribute() - $this->getTotalBuyPriceAttribute();
    }

    // scopes

    /**
     * filter quotes created this month
     *
     * @param $query
     * @return mixed
     */
    public function scopeThisMonth($query): mixed
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * filter quotes with pending statuses
     *
     * @param $query
     * @return mixed
     */
    public function scopePending($query): mixed
    {
        return $query->whereIn('status', [QuoteStatusEnum::Draft, QuoteStatusEnum::Sent]);
    }
}
