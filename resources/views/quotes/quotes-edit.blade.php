<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- "Quotes" Heading -->
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Quotes - ') . $quote->id }}
                </h2>
            </div>

            <x-quote-status-label
                :status="$quote->status"
                class="{{ \App\Enums\QuoteStatusEnum::from($quote->status)->labelClass() }}"
            >
                {{ __(ucfirst($quote->status)) }}
            </x-quote-status-label>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('quotes.partials.quote-financials')

            <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-lg">
                <div class="max-w-xl">
                    @include('quotes.partials.update-quote-information-form')
                </div>
            </div>

            @include('quotes.partials.quote-products-table')

            @include('quotes.partials.quote-actions')

            @include('quotes.partials.quote-emissions')

            @if(Auth::user()->isAdmin())
                <div class="p-4 sm:p-8 bg-white shadow-md sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('quotes.partials.delete-quote-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

