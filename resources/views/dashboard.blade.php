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

            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-2 gap-6 mb-6">

                <!-- Charts Section -->
                @include('dashboard.partials.performance-chart')

                @include('dashboard.partials.monthly-chart')
            </div>

            <!-- Dashboard Actions Section -->
            @include('dashboard.partials.dashboard-actions')

        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@vite(['resources/js/dashboard.js'])
