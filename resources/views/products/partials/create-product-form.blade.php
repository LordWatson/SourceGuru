<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Product Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Create the product details.") }}
        </p>
    </header>

    <form method="post" action="{{ route('products.store') }}" class="mt-6 space-y-6" x-data="catalogueProductForm()" x-init="fetchProductTypes(), fetchProductSubTypes()">
        @csrf
        @method('post')

        <!-- Product Name -->
        <div>
            <x-input-label for="name" :value="__('Product Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Product Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-area-input id="description" name="description" type="description" class="mt-1 block w-full" required></x-text-area-input>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <!-- Product Type -->
        <div class="flex flex-col space-y-4">
            <label for="product_type" class="block text-sm font-medium text-gray-700">
                {{ __('Product Type') }}
            </label>
            <select id="product_type" name="product_type_id" x-data="{}" x-model="selectedProductType"
                    x-on:change="fetchProductSubTypes()"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">{{ __('') }}</option>
                <template x-for="type in productTypes" :key="type.id">
                    <option :value="type.id" x-text="type.name"></option>
                </template>
            </select>
        </div>

        <!-- Product Sub Type -->
        <div class="flex flex-col space-y-4 mt-4">
            <label for="product_sub_type" class="block text-sm font-medium text-gray-700">
                {{ __('Product Sub Type') }}
            </label>
            <select id="product_sub_type" name="product_sub_type_id" x-data="{}" x-model="selectedProductSubType"
                    x-on:change="fetchProducts()"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">{{ __('') }}</option>
                <template x-for="subType in productSubTypes" :key="subType.id">
                    <option :value="subType.id" x-text="subType.name"></option>
                </template>
            </select>
        </div>

        <!-- Unit Buy Price -->
        <div>
            <x-input-label for="unit_buy_price" :value="__('Unit Buy Price')" />
            <x-text-input id="unit_buy_price" name="unit_buy_price" type="number" step="0.01" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('unit_buy_price')" class="mt-2" />
        </div>

        <!-- Unit Sell Price -->
        <div>
            <x-input-label for="unit_sell_price" :value="__('Unit Sell Price')" />
            <x-text-input id="unit_sell_price" name="unit_sell_price" type="number" step="0.01" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('unit_sell_price')" class="mt-2" />
        </div>

        <!-- Product Source -->
        <div class="flex flex-col space-y-4 mt-4">
            <label for="source" class="block text-sm font-medium text-gray-700">
                {{ __('Product Source') }}
            </label>
            <select id="source" name="source" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">{{ __('') }}</option>
                <option value="warehouse">Warehouse</option>
                <option value="online">Online</option>
                <option value="manufacturer">Manufacturer</option>
            </select>
        </div>

        <!-- Emission Benchmark -->
        <div>
            <x-input-label for="emission_benchmark" :value="__('Emission Benchmark (kg)')" />
            <x-text-input id="emission_benchmark" name="emission_benchmark" type="number" step="0.01" class="mt-1 block w-full" value="0.00" />
            <x-input-error :messages="$errors->get('emission_benchmark')" class="mt-2" />
        </div>

        <!-- Emission Result -->
        <div>
            <x-input-label for="emission_result" :value="__('Emission Result (kg)')" />
            <x-text-input id="emission_result" name="emission_result" type="number" step="0.01" class="mt-1 block w-full" value="0.00" />
            <x-input-error :messages="$errors->get('emission_result')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

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
