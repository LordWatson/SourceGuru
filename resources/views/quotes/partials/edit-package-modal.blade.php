<x-modal name="edit-package-{{ $product->id }}" :show="$errors->any()" maxWidth="60rem" focusable>
    <form method="post" action="{{ route('quote-items.updatePackage', $product->id) }}" class="p-6">
        @csrf
        @method('patch')

        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Edit Package: ') . $product->name }}
        </h2>

        <p class="text-sm text-gray-600 mb-6">
            {{ __('Change product selections, pricing, and quantities for this package') }}
        </p>

        <!-- Hidden fields to store updated data -->
        <input type="hidden" name="squashed_products" id="squashed_products_{{ $product->id }}">
        <input type="hidden" name="selected_options" id="selected_options_{{ $product->id }}">

        @php
            $squashedProducts = is_array($product->squashed_products)
                ? $product->squashed_products
                : json_decode($product->squashed_products ?? '[]', true);

            $selectedOptions = is_array($product->selected_options)
                ? $product->selected_options
                : json_decode($product->selected_options ?? '[]', true);

            // Load package with options and products
            $package = $product->package;
            if ($package) {
                $package->load(['options.products']);
            }
        @endphp

        @if(empty($squashedProducts))
            <div class="text-center py-8 text-gray-500">
                <p>No products found in this package.</p>
            </div>
        @else
            <!-- Package Products List -->
            <div class="space-y-2 max-h-96 overflow-y-auto"
                 x-data="{
                    openProducts: {},
                    products: @js($squashedProducts),
                    selectedOptions: @js($selectedOptions),
                    packageOptions: @js($package ? $package->options : []),

                    toggleProduct(index) {
                        this.openProducts[index] = !this.openProducts[index];
                    },
                    isOpen(index) {
                        return this.openProducts[index] === true;
                    },
                    updateHiddenFields() {
                        document.getElementById('squashed_products_{{ $product->id }}').value = JSON.stringify(this.products);
                        document.getElementById('selected_options_{{ $product->id }}').value = JSON.stringify(this.selectedOptions);
                    },
                    getProductsForOption(optionId) {
                        const option = this.packageOptions.find(opt => opt.id == optionId);
                        return option ? option.products : [];
                    },
                    getOptionForProduct(index) {
                        // Find which option this product belongs to
                        const productId = this.products[index].product_id;
                        return this.selectedOptions.find(opt => opt.product_id == productId);
                    },
                    changeProduct(index, newProductId) {
                        // Find the option this belongs to
                        const currentOption = this.getOptionForProduct(index);
                        if (!currentOption) return;

                        const option = this.packageOptions.find(opt => opt.id == currentOption.option_id);
                        if (!option) return;

                        const newProduct = option.products.find(p => p.id == newProductId);
                        if (!newProduct) return;

                        // Update the product in squashed_products
                        this.products[index].product_id = newProduct.id;
                        this.products[index].name = newProduct.name;
                        this.products[index].unit_buy_price = newProduct.pivot?.unit_buy_price || newProduct.unit_buy_price;
                        this.products[index].unit_sell_price = newProduct.pivot?.unit_sell_price || newProduct.unit_sell_price;

                        // Update the selected option
                        const selectedOptionIndex = this.selectedOptions.findIndex(o => o.option_id == currentOption.option_id);
                        if (selectedOptionIndex >= 0) {
                            this.selectedOptions[selectedOptionIndex].product_id = newProduct.id;
                        }

                        this.updateHiddenFields();
                    }
                 }"
                 x-init="updateHiddenFields()">

                @foreach($squashedProducts as $index => $prod)
                    @php
                        // Find which option this product belongs to
                        $productOption = collect($selectedOptions)->firstWhere('product_id', $prod['product_id'] ?? 0);
                        $optionId = $productOption['option_id'] ?? null;
                        $optionName = $prod['option_name'] ?? ($productOption['option_name'] ?? 'No Option');
                    @endphp

                    <div class="border border-gray-200 rounded-lg">
                        <!-- Collapsible Header -->
                        <button
                            type="button"
                            @click="toggleProduct({{ $index }})"
                            class="w-full px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors"
                        >
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-gray-500 transition-transform"
                                     :class="{ 'rotate-90': isOpen({{ $index }}) }"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <div class="text-left">
                                    <div class="font-medium text-gray-900" x-text="products[{{ $index }}].name"></div>
                                    <div class="text-xs text-gray-500">
                                        {{ $optionName }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>Qty: <span x-text="products[{{ $index }}].qty || 1"></span></span>
                                <span>£<span x-text="parseFloat(products[{{ $index }}].unit_sell_price || 0).toFixed(2)"></span></span>
                            </div>
                        </button>

                        <!-- Collapsible Content -->
                        <div x-show="isOpen({{ $index }})"
                             x-transition
                             class="px-4 py-4 border-t border-gray-200 bg-gray-50"
                             style="display: none;">

                            @if($package && $optionId)
                                <!-- Product Selection for this Option -->
                                <div class="mb-4">
                                    <x-input-label :value="__('Select Product')" />
                                    <select
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        @change="changeProduct({{ $index }}, $event.target.value)"
                                        x-model="products[{{ $index }}].product_id">
                                        <template x-for="prod in getProductsForOption({{ $optionId }})" :key="prod.id">
                                            <option
                                                :value="prod.id"
                                                x-text="prod.name + ' - £' + parseFloat(prod.pivot?.unit_sell_price || prod.unit_sell_price).toFixed(2)">
                                            </option>
                                        </template>
                                    </select>
                                </div>
                            @endif

                            <div class="grid grid-cols-3 gap-4">
                                <!-- Unit Buy Price -->
                                <div>
                                    <x-input-label :value="__('Unit Buy Price')" />
                                    <x-text-input
                                        type="number"
                                        step="0.01"
                                        x-model="products[{{ $index }}].unit_buy_price"
                                        @input="updateHiddenFields()"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>

                                <!-- Unit Sell Price -->
                                <div>
                                    <x-input-label :value="__('Unit Sell Price')" />
                                    <x-text-input
                                        type="number"
                                        step="0.01"
                                        x-model="products[{{ $index }}].unit_sell_price"
                                        @input="updateHiddenFields()"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>

                                <!-- Qty -->
                                <div>
                                    <x-input-label :value="__('Qty')" />
                                    <x-text-input
                                        type="number"
                                        step="0.01"
                                        x-model="products[{{ $index }}].qty"
                                        @input="updateHiddenFields()"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Update Package') }}
                </x-primary-button>
            </div>
        @endif
    </form>
</x-modal>
