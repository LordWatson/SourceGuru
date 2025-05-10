<x-modal id="attach-proposal" name="attach-proposal" focusable>
    <form
        method="post"
        action="{{ route('proposals.store') }}"
        enctype="multipart/form-data"
        id="proposal-form"
        class="p-6"
    >
        @csrf
        @method('post')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Attach Proposal') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 mb-4">
            {{ __('Proposal must be in PDF format. This proposal will be sent to the customer to check and approve.') }}
        </p>

        <input type="hidden" name="quote_id" value="{{ $quote->id }}">
        <div class="flex flex-col space-y-4">
            <!-- Name -->
            <div>
                <x-input-label for="proposal" :value="__('Proposal')" class="mb-2" />
                <input
                    type="file"
                    name="proposal"
                    id="proposal-file"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-100 focus:outline-none cursor-pointer"
                />
                <x-input-error :messages="$errors->get('proposal')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Attach') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
