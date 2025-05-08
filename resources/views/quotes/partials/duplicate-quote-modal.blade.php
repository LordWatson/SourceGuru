<x-modal id="duplicate-quote" name="duplicate-quote" focusable>
    <div class="flex flex-col space-y-4 p-6">
        <form action="{{ route('quotes.duplicate', $quote) }}" method="POST" class="d-inline">

            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Duplicate Quote') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 mb-4">
                {{ __('This quote, and its products, will be duplicated.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Duplicate') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
