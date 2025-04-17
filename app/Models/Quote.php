<?php

namespace App\Models;

use App\Enums\QuoteStatusEnum;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * filter quotes by company name
     *
     * @param Builder $query
     * @param $companyName
     * @return mixed
     */
    public function scopeFilterByCompany(Builder $query, $companyName): Builder
    {
        return $query->whereHas('company', function ($q) use ($companyName) {
            $q->where('name', 'like', "%$companyName%");
        });
    }

    /**
     * filter quotes by the name of the user that created the quote
     *
     * @param Builder $query
     * @param $userName
     * @return mixed
     */
    public function scopeFilterByUser(Builder $query, $userName): Builder
    {
        return $query->whereHas('user', function ($q) use ($userName) {
            $q->where('name', 'like', "%$userName%");
        });
    }

    /**
     * filter quotes by their status
     *
     * @param Builder $query
     * @param $status
     * @return mixed
     */
    public function scopeFilterByStatus(Builder $query, $status): Builder
    {
        return $query->where('status', 'like', "%$status%");
    }

    /**
     * filter general search on a quote
     * checks if the search value exists in multiple places
     *
     * @param Builder $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->where(function ($query) use ($search) {
            $query->whereHas('company', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
            $query->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
            $query->orWhere('quote_name', 'like', "%$search%");
            $query->orWhere('status', 'like', "%$search%");
        });
    }
}
