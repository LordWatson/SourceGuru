<?php

namespace App\Http\Controllers;

use App\Actions\Products\CreateProductAction;
use App\Actions\Products\FilterProductTypesAction;
use App\Actions\Quotes\FilterQuotesAction;
use App\Actions\Search\ParseSearchQueryAction;
use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Product;
use App\Models\ProductSubType;
use App\Models\ProductType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    public function create(FilterProductTypesAction $filterProductTypesAction)
    {
        $this->authorize('create', Product::class);

        $productTypes = $filterProductTypesAction->execute();

        return view('products.products-create', compact('productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request, CreateProductAction $createProductAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the product action
        $action = $createProductAction->execute($validated);

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to create product.']);

        // redirect to the products list
        return Redirect::to("/products")
            ->with('status', [
                'type' => 'create',
                'message' => 'Product created',
                'colour' => 'green',
            ]);
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
        $subTypes = Product::where('product_type_id', $typeId)->where('product_sub_type_id', $subTypeId)->get()->toArray();

        return response()->json($subTypes);
    }
}
