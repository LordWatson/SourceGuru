<x-modal id="place-order" name="place-order" focusable>
    <div class="flex flex-col space-y-4 p-6">
        <form action="{{ route('orders.store') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="quote_id" value="{{ $quote->id }}">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Place Order') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 mb-4">
                {{ __('This quote will be ordered and begin the order fulfillment process.') }}
                <br>
                {{ __('You will not be able to make any amendments after this point.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Place Order') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
