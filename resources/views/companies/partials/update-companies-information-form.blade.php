<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Company Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update the companies account details.") }}
        </p>
    </header>

    <form method="post" action="{{ route('companies.update', ['company' => $company->id]) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Company Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $company->name)" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="primary_contact_name" :value="__('Primary Contact Name')" />
            <x-text-input id="primary_contact_name" name="primary_contact_name" type="text" class="mt-1 block w-full" :value="old('primary_contact_name', $company->primary_contact_name)" required autofocus/>
            <x-input-error class="mt-2" :messages="$errors->get('primary_contact_name')" />
        </div>

        <div>
            <x-input-label for="primary_contact_email" :value="__('Primary Contact Email')" />
            <x-text-input id="primary_contact_email" name="primary_contact_email" type="email" class="mt-1 block w-full" :value="old('primary_contact_email', $company->primary_contact_email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('primary_contact_email')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-area-input id="address" name="address" type="address" class="mt-1 block w-full" :value="old('address', $company->address)" required >{{ __($company->address) }}</x-text-area-input>
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="primary_contact_phone" :value="__('Primary Contact Phone')" />
            <x-text-input id="primary_contact_phone" name="primary_contact_phone" class="mt-1 block w-full" :value="old('primary_contact_phone', $company->primary_contact_phone)" required />
            <x-input-error class="mt-2" :messages="$errors->get('primary_contact_phone')" />
        </div>

        <div>
            <x-input-label for="account_manager_id" :value="__('Account Manager')" />
            <select id="account_manager_id" name="account_manager_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $company->account_manager_id ? 'selected' : '' }}>
                        {{ ucwords($user->name) }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('account_manager_id')" />
        </div>

        <div>
            <x-input-label for="notes" :value="__('Notes')" />
            <x-text-area-input id="notes" name="notes" type="notes" class="mt-1 block w-full" :value="old('notes', $company->notes)" placeholder="Closed every Friday, discounted shipping...">{{ __($company->notes) }}</x-text-area-input>
            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
        </div>

        @if(Auth::user()->isAdmin())
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                @if(session('status') === 'company-updated')
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
