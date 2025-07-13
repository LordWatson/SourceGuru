<x-modal name="add-quote-item" focusable>
    <form method="post" action="{{ route('quote-items.store') }}" class="p-6">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Product') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Total Buy and Total Sel Prices are calculated once the product is updated') }}
        </p>

        <div class="flex flex-col space-y-4">

            <!-- Dropdown -->
            <div>
                <x-input-label for="product-dropdown" :value="__('Select Product Type')" />
                <select id="product-dropdown" name="product_type" x-model="selectedOption" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option disabled selected>{{ __('Choose an option') }}</option>
                    <option @click="$dispatch('open-modal', 'add-bespoke-product')">{{ __('Bespoke Product') }}</option>
                    <option @click="$dispatch('open-modal', 'add-catalogue-product')">{{ __('Catalogue Product') }}</option>
                    <option>{{ __('Package') }}</option>
                    <option>{{ __('Run Workflow') }}</option>
                    <option>{{ __('Live Billing') }}</option>
                </select>
            </div>
        </div>
    </form>
</x-modal>
