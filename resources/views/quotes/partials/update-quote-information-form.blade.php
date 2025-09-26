<section x-data="{ open: false }">
    <header>
        <button
            type="button"
            class="w-[200%] flex items-center justify-between text-left group"
            @click="open = !open"
            :aria-expanded="open.toString()"
            aria-controls="quote-info-form"
        >
            <div class="flex-1">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Quote Information') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Update the quote details.") }}
                </p>
            </div>

            <svg
                class="ml-4 h-5 w-5 shrink-0 text-gray-500 transition-transform duration-200 group-hover:text-gray-700"
                :class="open ? 'rotate-180' : 'rotate-0'"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
            >
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.173l3.71-2.942a.75.75 0 111.04 1.08l-4.24 3.363a.75.75 0 01-.94 0L5.21 8.31a.75.75 0 01.02-1.1z" clip-rule="evenodd" />
            </svg>
        </button>
    </header>


    <form
        id="quote-info-form"
        x-show="open"
        x-transition
        method="post"
        action="{{ route('quotes.update', ['quote' => $quote->id]) }}"
        class="mt-6 space-y-6"
    >
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
                    <option value="{{ $user->id }}" {{ $user->id == $quote->user_id ? 'selected' : '' }}>
                        {{ ucwords($user->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
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
                        {{ $quote->status === $status->value ? 'selected' : '' }}
                    >
                        {{ ucfirst($status->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
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
