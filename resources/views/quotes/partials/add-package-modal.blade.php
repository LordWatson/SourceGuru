<x-modal name="add-package" focusable>
    <form method="post" action="{{ route('quote-items.addPackage', ['quoteId' => $quote->id]) }}" class="p-6" x-data="packageForm()" x-init="fetchPackages()">
        @csrf
        @method('post')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Package') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Total Buy and Total Sel Prices are calculated once the package is updated') }}
        </p>

        <div class="flex flex-col space-y-4">

            <!-- Quote ID -->
            <input type="hidden" name="quote_id" value="{{ $quoteId }}">

            <div class="flex flex-col space-y-4">
                <!-- Package Type -->
                <label for="package" class="block text-sm font-medium text-gray-700">
                    {{ __('Package') }}
                </label>
                <select id="package" name="package"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Select Package') }}</option>
                    <template x-for="package in packages" :key="package.id">
                        <option :value="package.id" x-text="package.name"></option>
                    </template>
                </select>
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

<script>
    function packageForm() {
        return {
            packages: [],
            fetchPackages() {
                axios.get('/api/get-packages')
                    .then(response => { this.packages = response.data; })
                    .catch(error => { console.error(error); });
            }
        };
    }
</script>
