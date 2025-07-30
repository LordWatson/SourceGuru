<x-modal name="confirm-quote-items-deletion-{{ $product->id }}" :show="$errors->quoteDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('quote-items.destroy', $product->id) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this product?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Removing this product will reduce the revenue of the quote.') }}
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
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Product') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
