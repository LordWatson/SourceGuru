<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Quote Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Create the initial quote data.") }}
        </p>
    </header>

    <form method="post" action="{{ route('quotes.store') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="quote_name" :value="__('Quote Name')" />
            <x-text-input id="quote_name" name="quote_name" type="text" class="mt-1 block w-full" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('quote_name')" />
        </div>

        <div>
            <x-input-label for="company_id" :value="__('Company')" />
            <select required id="company_id" name="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option disabled selected>- -</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">
                        {{ ucwords($company->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Quote Status')" />
            <select
                required
                id="quote_status"
                name="status"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                @foreach($statuses as $status)
                    <option
                        value="{{ $status->value }}"
                        {{ $status->value === 'draft' ? 'selected' : '' }}
                    >
                        {{ ucfirst($status->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div id="completed_date_field" class="hidden">
            <x-input-label for="completed_date" :value="__('Completed Date')" />
            <x-text-input id="completed_date" name="completed_date" type="date" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('completed_date')" />
        </div>

        <div id="expired_date_field" class="hidden">
            <x-input-label for="expired_date" :value="__('Expired Date')" />
            <x-text-input id="expired_date" name="expired_date" type="date" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('expired_date')" />
        </div>

        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-area-input id="notes" name="notes" type="notes" class="mt-1 block w-full" placeholder="Quote for a new startup company. Welcome package for new staff..."></x-text-area-input>
            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

@vite(['resources/js/create-quote.js'])
