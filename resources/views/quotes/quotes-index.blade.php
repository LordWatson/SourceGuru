<x-app-layout>
    @vite(['resources/css/quotes.css'])

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- "Quotes" Heading -->
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Quotes') }}
                </h2>

                <!-- Refined Filter Dropdown -->
                <form action="{{ route('quotes.index') }}" method="GET">
                    <select name="search"
                            onchange="this.form.submit()"
                            class="text-sm text-gray-800 border border-gray-300 rounded-md focus:ring-gray-300 focus:border-gray-300">
                        <option value="">All</option>
                        <option
                            value="user={{ auth()->user()->name }}"
                            {{ request('search') === 'user=' . auth()->user()->name ? 'selected' : '' }}
                        >
                            My Quotes
                        </option>
                        @foreach($statuses as $status)
                            <option
                                value="status={{ $status->value }}"
                                {{ request('search') === 'status=' . $status->value ? 'selected' : '' }}
                            >
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- New Quote Button -->
            <a href="{{ route('quotes.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent border-gray-500 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                New Quote
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @include('quotes.partials.quotes-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite(['resources/js/quotes.js'])
