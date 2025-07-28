<?php

namespace App\Actions\Products;

use App\Actions\CreateAction;
use App\Models\Product;

class CreateProductAction extends CreateAction
{
    protected function createModelInstance(array $data): Product
    {
        return Product::create($data);
    }
}
