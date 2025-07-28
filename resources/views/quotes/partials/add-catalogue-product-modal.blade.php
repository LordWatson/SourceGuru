<x-modal name="add-catalogue-product" focusable>
    <form method="post" action="{{ route('quote-items.addCatalogueProduct', ['quoteId' => $quote->id]) }}" class="p-6" x-data="catalogueProductForm()" x-init="fetchProductTypes(), fetchProductSubTypes(), fetchProducts()">
        @csrf
        @method('post')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Product') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Total Buy and Total Sel Prices are calculated once the product is updated') }}
        </p>

        <div class="flex flex-col space-y-4">

            <!-- Quote ID -->
            <input type="hidden" name="quote_id" value="{{ $quoteId }}">

            <div class="flex flex-col space-y-4">
                <!-- Product Type -->
                <label for="product_type" class="block text-sm font-medium text-gray-700">
                    {{ __('Product Type') }}
                </label>
                <select id="product_type" name="product_type" x-data="{}" x-model="selectedProductType"
                        x-on:change="fetchProductSubTypes()"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Select Product Type') }}</option>
                    <template x-for="type in productTypes" :key="type.id">
                        <option :value="type.id" x-text="type.name"></option>
                    </template>
                </select>
            </div>

            <div class="flex flex-col space-y-4 mt-4">
                <!-- Product Sub Type -->
                <label for="product_sub_type" class="block text-sm font-medium text-gray-700">
                    {{ __('Product Sub Type') }}
                </label>
                <select id="product_sub_type" name="product_sub_type" x-data="{}" x-model="selectedProductSubType"
                        x-on:change="fetchProducts()"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Select Product Sub Type') }}</option>
                    <template x-for="subType in productSubTypes" :key="subType.id">
                        <option :value="subType.id" x-text="subType.name"></option>
                    </template>
                </select>
            </div>

            <div class="flex flex-col space-y-4 mt-4">
                <!-- Product -->
                <label for="product" class="block text-sm font-medium text-gray-700">
                    {{ __('Product') }}
                </label>
                <select id="product" name="product" x-data="{}"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Select Product') }}</option>
                    <template x-for="product in products" :key="product.id">
                        <option :value="product.id" x-text="product.name"></option>
                    </template>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

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
