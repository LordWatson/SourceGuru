<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company - ') . $company->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('companies.partials.update-companies-information-form')
                </div>
            </div>

            @include('companies.partials.companies-quotes-table')

            @if(Auth::user()->isAdmin())
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('companies.partials.delete-companies-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


<script>
    @if(!Auth::user()->isAdmin())
        // apply readonly to all inputs
        document.querySelectorAll('input, textarea, select').forEach(el => el.disabled = true);
    @endif
</script>

@vite(['resources/js/companies.js'])
