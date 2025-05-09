<x-modal name="duplicate-quote-item-{{ $product->id }}" :show="$errors->quoteDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('quote-items.duplicate', $product->id) }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Duplicate this product?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Duplicating this product will add another instance of this product to the quote.') }}
        </p>

        <!-- Product Summary Section -->
        <div class="mt-4">
            <h3 class="text-sm font-medium text-gray-800">
                {{ __('Product Details:') }}
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                <strong>{{ __('Name:') }}</strong> {{ $product->name }}
            </p>
            <p class="text-sm text-gray-600 mt-1">
                <strong>{{ __('Description:') }}</strong> {{ $product->description }}
            </p>
            <p class="text-sm text-gray-600 mt-1">
                <strong>{{ __('Quantity:') }}</strong> {{ $product->quantity }}
            </p>
            <p class="text-sm text-gray-600 mt-1">
                <strong>{{ __('Total Sell Price:') }}</strong> £{{ number_format($product->total_sell_price, 2) }}
            </p>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Duplicate') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
