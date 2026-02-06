<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageOption;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::with('options')->orderBy('name')->get();
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $package = Package::create($validated);

        return redirect()->route('packages.edit', $package)
            ->with('status', [
                'type' => 'create',
                'message' => 'Package created',
                'colour' => 'green',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        $package->load(['options.products']);
        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $package->load(['options.products']);
        $products = Product::orderBy('name')->get();
        return view('packages.edit', compact('package', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $package->update($validated);

        return redirect()->route('packages.edit', $package)
            ->with('status', [
                'type' => 'update',
                'message' => 'Package updated',
                'colour' => 'green',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('status', [
                'type' => 'delete',
                'message' => 'Package deleted',
                'colour' => 'red',
            ]);
    }

    /**
     * Store a new option for a package
     */
    public function storeOption(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $package->options()->create($validated);

        return redirect()->route('packages.edit', $package)
            ->with('status', [
                'type' => 'create',
                'message' => 'Option added',
                'colour' => 'green',
            ]);
    }

    /**
     * Update an option
     */
    public function updateOption(Request $request, PackageOption $option)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $option->update($validated);

        return redirect()->route('packages.edit', $option->package_id)
            ->with('status', [
                'type' => 'update',
                'message' => 'Option updated',
                'colour' => 'green',
            ]);
    }

    /**
     * Delete an option
     */
    public function destroyOption(PackageOption $option)
    {
        $packageId = $option->package_id;
        $option->delete();

        return redirect()->route('packages.edit', $packageId)
            ->with('status', [
                'type' => 'delete',
                'message' => 'Option deleted',
                'colour' => 'red',
            ]);
    }

    /**
     * Add products to an option
     */
    public function addProductsToOption(Request $request, PackageOption $option)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.unit_buy_price' => 'required|numeric|min:0',
            'products.*.unit_sell_price' => 'required|numeric|min:0',
        ]);

        foreach ($validated['products'] as $productData) {
            $option->products()->attach($productData['product_id'], [
                'unit_buy_price' => $productData['unit_buy_price'],
                'unit_sell_price' => $productData['unit_sell_price'],
            ]);
        }

        return redirect()->route('packages.edit', $option->package_id)
            ->with('status', [
                'type' => 'create',
                'message' => 'Products added to option',
                'colour' => 'green',
            ]);
    }

    /**
     * Remove a product from an option
     */
    public function removeProductFromOption(PackageOption $option, Product $product)
    {
        $option->products()->detach($product->id);

        return redirect()->route('packages.edit', $option->package_id)
            ->with('status', [
                'type' => 'delete',
                'message' => 'Product removed from option',
                'colour' => 'red',
            ]);
    }

    /**
     * Get packages for API
     */
    public function getPackages(Request $request)
    {
        $packages = Package::with(['options.products'])->get();
        return response()->json($packages);
    }

    /**
     * Get a specific package with options
     */
    public function getPackageWithOptions(Package $package)
    {
        $package->load(['options.products']);
        return response()->json($package);
    }
}
