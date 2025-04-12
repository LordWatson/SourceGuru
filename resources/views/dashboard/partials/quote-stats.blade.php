<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-6 mb-6">
    <!-- Total Quotes -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500">Total Quotes</h3>
        <p class="mt-1 text-2xl font-bold text-gray-900">
            {{ $data['totalQuotes'] }}
        </p>
    </div>

    <!-- Quotes This Month -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500">Quotes This Month</h3>
        <p class="mt-1 text-2xl font-bold text-gray-900">
            {{ $data['thisMonth'] }}
        </p>
    </div>

    <!-- Pending Quotes -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500">Pending Quotes</h3>
        <p class="mt-1 text-2xl font-bold text-gray-900">
            {{ $data['pendingQuotes'] }}
        </p>
    </div>
</div>
