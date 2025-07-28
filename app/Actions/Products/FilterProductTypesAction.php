<?php

namespace App\Actions\Products;

use App\Models\ProductType;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterProductTypesAction
{
    /**
     * Create the action.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $filters
     * @param $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function execute($search = null): \Illuminate\Database\Eloquent\Collection
    {
        /*
         * get product types, sub types, and products associated with it
         * applies a search query on the name column of the models
         * @see ProductController::index
         * */
        return ProductType::with([
            'subTypes' => function ($query) {
                $query->select('id', 'name', 'product_type_id');
            },
            'subTypes.products' => function ($query) {
                $query->select('id', 'name', 'product_type_id', 'product_sub_type_id');
            }
        ])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('subTypes', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%")
                            ->orWhereHas('products', function ($productQuery) use ($search) {
                                $productQuery->where('name', 'like', "%{$search}%");
                            });
                    });
            })
            ->get();
    }
}
