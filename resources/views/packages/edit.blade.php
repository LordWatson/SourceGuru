<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Package: ') . $package->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Package Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Package Details</h3>
                    <form method="POST" action="{{ route('packages.update', $package) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       value="{{ old('name', $package->name) }}">
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $package->description) }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" {{ $package->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $package->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Update Package
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Package Options -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="optionManager()">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Package Options</h3>
                        <button @click="showAddOptionForm = !showAddOptionForm" type="button"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Add Option
                        </button>
                    </div>

                    <!-- Add Option Form -->
                    <div x-show="showAddOptionForm" class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <form method="POST" action="{{ route('packages.options.store', $package) }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="option_name" class="block text-sm font-medium text-gray-700">Option Name</label>
                                    <input type="text" name="name" id="option_name" required placeholder="e.g., Circuit, Router, Firewall"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="option_description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                    <input type="text" name="description" id="option_description"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" value="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" @click="showAddOptionForm = false"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                        Save Option
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Options List -->
                    @if($package->options->isEmpty())
                        <p class="text-gray-500">No options added yet. Add your first option to configure this package.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($package->options as $option)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="text-md font-semibold text-gray-900">{{ $option->name }}</h4>
                                            @if($option->description)
                                                <p class="text-sm text-gray-500">{{ $option->description }}</p>
                                            @endif
                                        </div>
                                        <form method="POST" action="{{ route('package-options.destroy', $option) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Delete this option?')">
                                                Delete Option
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Products in this option -->
                                    <div class="mt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h5 class="text-sm font-medium text-gray-700">Products</h5>
                                            <button @click="showAddProductForm[{{ $option->id }}] = !showAddProductForm[{{ $option->id }}]" type="button"
                                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Add Products
                                            </button>
                                        </div>

                                        <!-- Add Product Form -->
                                        <div x-show="showAddProductForm[{{ $option->id }}]" class="mb-4 p-3 bg-gray-50 rounded">
                                            <form method="POST" action="{{ route('package-options.products.add', $option) }}" x-data="productSelector()">
                                                @csrf
                                                <div class="space-y-3">
                                                    <template x-for="(product, index) in selectedProducts" :key="index">
                                                        <div class="flex gap-2">
                                                            <select :name="'products[' + index + '][product_id]'" required
                                                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                                <option value="">Select Product</option>
                                                                @foreach($products as $product)
                                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="number" :name="'products[' + index + '][unit_buy_price]'" step="0.01" placeholder="Buy Price" required
                                                                   class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                            <input type="number" :name="'products[' + index + '][unit_sell_price]'" step="0.01" placeholder="Sell Price" required
                                                                   class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                            <button type="button" @click="selectedProducts.splice(index, 1)"
                                                                    class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                                                        </div>
                                                    </template>
                                                    <button type="button" @click="selectedProducts.push({})"
                                                            class="text-indigo-600 hover:text-indigo-900 text-sm">+ Add Another Product</button>
                                                </div>
                                                <div class="mt-3 flex justify-end space-x-2">
                                                    <button type="button" @click="showAddProductForm[{{ $option->id }}] = false; selectedProducts = [{}]"
                                                            class="px-3 py-1 bg-white border border-gray-300 rounded-md text-xs text-gray-700 hover:bg-gray-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="px-3 py-1 bg-indigo-600 border border-transparent rounded-md text-xs text-white hover:bg-indigo-700">
                                                        Save Products
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        @if($option->products->isEmpty())
                                            <p class="text-sm text-gray-500">No products added to this option yet.</p>
                                        @else
                                            <div class="space-y-2">
                                                @foreach($option->products as $product)
                                                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded text-sm">
                                                        <span>{{ $product->name }}</span>
                                                        <div class="flex items-center gap-4">
                                                            <span class="text-gray-600">Buy: £{{ number_format($product->pivot->unit_buy_price, 2) }}</span>
                                                            <span class="text-gray-600">Sell: £{{ number_format($product->pivot->unit_sell_price, 2) }}</span>
                                                            <form method="POST" action="{{ route('package-options.products.remove', [$option, $product]) }}" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Remove this product?')">
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function optionManager() {
            return {
                showAddOptionForm: false,
                showAddProductForm: {}
            }
        }

        function productSelector() {
            return {
                selectedProducts: [{}]
            }
        }
    </script>
</x-app-layout>
