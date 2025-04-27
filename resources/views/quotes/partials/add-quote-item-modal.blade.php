<x-modal name="add-quote-item" focusable>
    <form method="post" action="{{ route('quote-items.store') }}" class="p-6">
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

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="description" :value="__('Description')" />
                <x-text-area-input id="description" name="description" class="mt-1 block w-full" :rows="3"></x-text-area-input>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Product Source -->
            <div>
                <x-input-label for="product_source" :value="__('Product Source')" />
                <x-text-input id="product_source" name="product_source" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('product_source')" class="mt-2" />
            </div>

            <!-- Quantity -->
            <div>
                <x-input-label for="quantity" :value="__('Quantity')" />
                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" min="1" required />
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
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
