<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Section -->
            @include('dashboard.partials.quote-stats')

            <!-- Recent Quotes Section -->
            @include('dashboard.partials.recent-quotes-table')

            <!-- Charts Section -->
            @include('dashboard.partials.performance-chart')

            <!-- Dashboard Actions Section -->
{{--            @include('dashboard.partials.dashboard-actions')--}}

        </div>
    </div>
</x-app-layout>

@vite(['resources/js/dashboard.js'])
