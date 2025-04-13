<?php

namespace App\Models;

use App\Enums\QuoteStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $casts = [
        'expired_date' => 'date',
        'created_at' => 'datetime:Y-m-d',
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

    public function totalSellPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->products->sum('unit_sell_price')
        );
    }

    public function totalBuyPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->products->sum('unit_buy_price')
        );
    }

    public function revenue(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->total_sell_price - $this->total_buy_price
        );
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
