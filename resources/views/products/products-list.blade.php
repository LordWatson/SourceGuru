<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent border-gray-500 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                New Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr class="bg-gray-50 text-left">
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Name
                            </th>
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Description
                            </th>
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Source
                            </th>
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Buy Price
                            </th>
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Sell Price
                            </th>
                            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ \Illuminate\Support\Str::words($product->description, 3, '...') }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $product->source }}</td>
                                <td class="px-4 py-2 text-sm">£{{ number_format($product->unit_buy_price, 2) }}</td>
                                <td class="px-4 py-2 text-sm">£{{ number_format($product->unit_sell_price, 2) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <p>
                                        <x-edit-action
                                            x-data="{{ $product }}"
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-quote-item-{{ $product->id }}')"
                                        >
                                            {{ __('Edit') }}
                                        </x-edit-action>
                                        <span class="text-gray-400">|</span>
                                        <x-delete-action
                                            x-data="{{ $product }}"
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-quote-items-deletion-{{ $product->id }}')"
                                        >
                                            {{ __('Delete') }}
                                        </x-delete-action>

                                        @include('products.partials.edit-product-modal', ['product' => $product])

                                        @include('products.partials.delete-product-modal', ['product' => $product])
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function catalogueProductForm() {
        return {
            productTypes: [],
            productSubTypes: [],
            products: [],
            selectedProductType: '',
            selectedProductSubType: '',
            fetchProductTypes() {
                axios.get('/api/get-product-types')
                    .then(response => { this.productTypes = response.data; })
                    .catch(error => { console.error(error); });
            },
            fetchProductSubTypes() {
                if (!this.selectedProductType) return;
                axios.get(`/api/get-product-sub-types/${this.selectedProductType}`)
                    .then(response => { this.productSubTypes = response.data; })
                    .catch(error => { console.error(error); });
            },
            fetchProducts() {
                if (!this.selectedProductType || !this.selectedProductSubType) return;
                axios.get(`/api/get-products/${this.selectedProductType}/${this.selectedProductSubType}`)
                    .then(response => { this.products = response.data; })
                    .catch(error => { console.error(error); });
            }
        };
    }
</script>
