<x-modal name="edit-quote-item-{{ $product->id }}" focusable>
    <form method="post" action="{{ route('quote-items.update', $product->id) }}" class="p-6" x-data="catalogueProductForm()" x-init="fetchProductTypes(), fetchProductSubTypes()">
        @csrf
        @method('patch')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Product') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Total Buy and Total Sel Prices are calculated once the product is updated') }}
        </p>

        <div class="flex flex-col space-y-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$product->name" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-text-area-input id="description" name="description" class="mt-1 block w-full" required>{{ $product->description }}</x-text-area-input>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
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
                        <option :value="type.id" x-text="type.name" :selected="type.id == {{ $product->product_type_id }}"></option>
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
                        <option :value="subType.id" x-text="subType.name" :selected="type.id == {{ $product->product_type_id }}"></option>
                    </template>
                </select>
            </div>

            <!-- Product Source -->
            <div>
                <x-input-label for="product_source" :value="__('Product Source')" />
                <x-text-input id="product_source" name="product_source" type="text" class="mt-1 block w-full" :value="$product->source" required />
                <x-input-error :messages="$errors->get('product_source')" class="mt-2" />
            </div>

            <!-- Unit Buy Price -->
            <div>
                <x-input-label for="unit_buy_price" :value="__('Unit Buy Price')" />
                <x-text-input id="unit_buy_price" name="unit_buy_price" type="number" step="0.01" class="mt-1 block w-full" :value="$product->unit_buy_price" required />
                <x-input-error :messages="$errors->get('unit_buy_price')" class="mt-2" />
            </div>

            <!-- Unit Sell Price -->
            <div>
                <x-input-label for="unit_sell_price" :value="__('Unit Sell Price')" />
                <x-text-input id="unit_sell_price" name="unit_sell_price" type="number" step="0.01" class="mt-1 block w-full" :value="$product->unit_sell_price" required />
                <x-input-error :messages="$errors->get('unit_sell_price')" class="mt-2" />
            </div>

            <!-- Emission Benchmark -->
            <div>
                <x-input-label for="emission_benchmark" :value="__('Emission Benchmark (kg)')" />
                <x-text-input id="emission_benchmark" name="emission_benchmark" type="number" step="0.01" class="mt-1 block w-full" :value="$product->emission_benchmark" />
                <x-input-error :messages="$errors->get('emission_benchmark')" class="mt-2" />
            </div>

            <!-- Emission Result -->
            <div>
                <x-input-label for="emission_result" :value="__('Emission Result (kg)')" />
                <x-text-input id="emission_result" name="emission_result" type="number" step="0.01" class="mt-1 block w-full" :value="$product->emission_result" />
                <x-input-error :messages="$errors->get('emission_result')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
