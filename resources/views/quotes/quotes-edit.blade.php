<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- "Quotes" Heading -->
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Quotes - ') . $quote->id }}
                </h2>
            </div>

            @php
                $class = '';
                if (in_array($quote->status, ['accepted', 'completed'])) {
                    $class = 'bg-green-100 text-green-800';
                } elseif (in_array($quote->status, ['rejected', 'expired'])) {
                    $class = 'bg-red-100 text-red-800';
                } elseif (in_array($quote->status, ['sent', 'draft'])) {
                    $class = 'bg-yellow-100 text-yellow-800';
                }
            @endphp

            <x-quote-status-label :status="$quote->status" :class="$class">
                {{ __(ucfirst($quote->status)) }}
            </x-quote-status-label>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('quotes.partials.update-quote-information-form')
                </div>
            </div>

{{--            @include('quotes.partials.quote-products-table')--}}

            @if(Auth::user()->isAdmin())
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('quotes.partials.delete-quote-form')
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
