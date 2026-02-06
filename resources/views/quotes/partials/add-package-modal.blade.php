<x-modal name="add-package" maxWidth="60rem" focusable>
    <form method="post" action="{{ route('quote-items.addPackage', ['quoteId' => $quote->id]) }}" class="p-6" x-data="packageForm()" x-init="fetchPackages()">
        @csrf
        @method('post')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Package') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Select a package and choose products for each option') }}
        </p>

        <div class="flex flex-col space-y-4">
            <!-- Quote ID -->
            <input type="hidden" name="quote_id" value="{{ $quoteId }}">

            <!-- Package Selection -->
            <div class="flex flex-col space-y-2">
                <label for="package" class="block text-sm font-medium text-gray-700">
                    {{ __('Package') }}
                </label>
                <select
                    id="package"
                    name="package"
                    x-model="selectedPackageId"
                    @change="loadPackageOptions()"
                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                    <option value="">{{ __('Select Package') }}</option>
                    <template x-for="package in packages" :key="package.id">
                        <option :value="package.id" x-text="package.name"></option>
                    </template>
                </select>
            </div>

            <!-- Package Options -->
            <div x-show="packageOptions.length > 0" class="space-y-4 mt-4">
                <h3 class="text-md font-medium text-gray-900">{{ __('Select Products for Each Option') }}</h3>

                <template x-for="(option, optionIndex) in packageOptions" :key="option.id">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <label :for="'option_' + option.id" class="block text-sm font-medium text-gray-700 mb-2">
                            <span x-text="option.name"></span>
                            <span class="text-gray-500 text-xs" x-show="option.description" x-text="' - ' + option.description"></span>
                        </label>
                        <select
                            :id="'option_' + option.id"
                            :name="'options[' + option.id + ']'"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            required>
                            <option value="">{{ __('Select Product') }}</option>
                            <template x-for="(product, productIndex) in option.products" :key="'opt' + optionIndex + 'prod' + productIndex">
                                <option :value="product.id" x-text="getProductDisplay(product)"></option>
                            </template>
                        </select>
                    </div>
                </template>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-4">
                <span class="text-gray-500">{{ __('Loading options...') }}</span>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Add Package') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>

<script>
    function packageForm() {
        return {
            packages: [],
            selectedPackageId: '',
            packageOptions: [],
            loading: false,

            fetchPackages() {
                axios.get('/api/get-packages')
                    .then(response => {
                        this.packages = response.data;
                    })
                    .catch(error => {
                        console.error('Error fetching packages:', error);
                    });
            },

            loadPackageOptions() {
                if (!this.selectedPackageId) {
                    this.packageOptions = [];
                    return;
                }

                this.loading = true;
                axios.get(`/api/packages/${this.selectedPackageId}/options`)
                    .then(response => {
                        console.log('Package options loaded:', response.data);
                        this.packageOptions = response.data.options || [];
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Error loading package options:', error);
                        this.packageOptions = [];
                        this.loading = false;
                    });
            },

            getProductDisplay(product) {
                const price = product.pivot?.unit_sell_price || product.unit_sell_price || 0;
                return `${product.name} - £${parseFloat(price).toFixed(2)}`;
            }
        };
    }
</script>
