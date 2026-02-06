<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
        'current_version_id',
        'status',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'package_products')
            ->withTimestamps();
    }

    public function versions(): HasMany
    {
        return $this->hasMany(PackageVersion::class);
    }

    public function currentVersion(): BelongsTo
    {
        return $this->belongsTo(PackageVersion::class, 'current_version_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(PackageOption::class)->orderBy('sort_order');
    }
}
