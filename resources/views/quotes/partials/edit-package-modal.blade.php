<x-modal name="edit-package-{{ $product->id }}" :show="$errors->any()" maxWidth="60rem" focusable>
    <form method="post" action="{{ route('quote-items.updatePackage', $product->id) }}" class="p-6">
        @csrf
        @method('patch')

        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ __('Edit Package: ') . $product->name }}
        </h2>

        <p class="text-sm text-gray-600 mb-6">
            {{ __('Edit pricing for each product in this package') }}
        </p>

        <!-- Hidden field to store updated products -->
        <input type="hidden" name="squashed_products" id="squashed_products_{{ $product->id }}">

        @php
            $squashedProducts = is_array($product->squashed_products)
                ? $product->squashed_products
                : json_decode($product->squashed_products ?? '[]', true);
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
                    toggleProduct(index) {
                        this.openProducts[index] = !this.openProducts[index];
                    },
                    isOpen(index) {
                        return this.openProducts[index] === true;
                    },
                    updateHiddenField() {
                        document.getElementById('squashed_products_{{ $product->id }}').value = JSON.stringify(this.products);
                    }
                 }"
                 x-init="updateHiddenField()">

                @foreach($squashedProducts as $index => $prod)
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
                                <span class="font-medium text-gray-900">{{ $prod['name'] ?? 'Unnamed Product' }}</span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                <span>£<span x-text="parseFloat(products[{{ $index }}].unit_sell_price || 0).toFixed(2)"></span></span>
                            </div>
                        </button>

                        <!-- Collapsible Content -->
                        <div x-show="isOpen({{ $index }})"
                             x-transition
                             class="px-4 py-4 border-t border-gray-200 bg-gray-50"
                             style="display: none;">
                            <div class="grid grid-cols-3 gap-4">
                                <!-- Unit Buy Price -->
                                <div>
                                    <x-input-label :value="__('Unit Buy Price')" />
                                    <x-text-input
                                        type="number"
                                        step="0.01"
                                        x-model="products[{{ $index }}].unit_buy_price"
                                        @input="updateHiddenField()"
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
                                        @input="updateHiddenField()"
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
                                        @input="updateHiddenField()"
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
