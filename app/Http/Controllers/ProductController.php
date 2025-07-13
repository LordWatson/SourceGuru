<?php

namespace App\Http\Controllers;

use App\Actions\Products\FilterProductTypesAction;
use App\Actions\Quotes\FilterQuotesAction;
use App\Actions\Search\ParseSearchQueryAction;
use App\Models\Product;
use App\Models\ProductSubType;
use App\Models\ProductType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterProductTypesAction $filterProductTypesAction)
    {
        $search = $request->input('search');

        $productTypes = $filterProductTypesAction->execute($search);

        return view('products.products-index', compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $Product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $Product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $Product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $Product)
    {
        //
    }

    public function getProductTypes(Request $request)
    {
        $types = ProductType::all()->select('id', 'name')->toArray();

        return response()->json($types);
    }

    public function getProductSubTypes(Request $request, int $typeId)
    {
        $subTypes = ProductSubType::where('product_type_id', $typeId)->get()->toArray();

        return response()->json($subTypes);
    }


    public function getProducts(Request $request, int $typeId, int $subTypeId)
    {
        $subTypes = Product::where('product_type_id', $typeId)->where('product_sub_type_id', $typeId)->get()->toArray();

        return response()->json($subTypes);
    }
}
