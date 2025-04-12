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

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('companies.partials.delete-companies-form')
                </div>
            </div>
        </div>
    </div>


</x-app-layout>


<script>
    document.getElementById('primary_contact_phone').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, ''); // Allow only digits
    });
</script>
