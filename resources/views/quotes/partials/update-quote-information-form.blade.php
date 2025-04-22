<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Quote Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update the quote details.") }}
        </p>
    </header>

    <form method="post" action="{{ route('quotes.update', ['quote' => $quote->id]) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="quote_name" :value="__('Quote Name')" />
            <x-text-input id="quote_name" name="quote_name" type="text" class="mt-1 block w-full" :value="old('quote_name', $quote->quote_name)" required/>
            <x-input-error class="mt-2" :messages="$errors->get('quote_name')" />
        </div>

        <div>
            <x-input-label for="company_id" :value="__('Company')" />
            <select id="company_id" name="company_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ $company->id == $quote->company_id ? 'selected' : '' }}>
                        {{ ucwords($company->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
        </div>

        <div>
            <x-input-label for="user_id" :value="__('Quoted By')" />
            <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $quote->company_id ? 'selected' : '' }}>
                        {{ ucwords($user->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
        </div>

        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-area-input id="notes" name="notes" type="notes" class="mt-1 block w-full" :value="old('notes', $quote->notes)">{{ __($quote->notes) }}</x-text-area-input>
            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
        </div>

        @if(Auth::user()->isAdmin())
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if(session('status') === 'quote-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        @endif
    </form>
</section>
