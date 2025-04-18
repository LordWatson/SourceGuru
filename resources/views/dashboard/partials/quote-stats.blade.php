<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-6 mb-6">
    <!-- Total Quotes -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Total Quotes
            <span class="ml-2 text-xs text-indigo-600 font-medium bg-indigo-50 px-2 py-1 rounded">
                {{ now()->format('Y') }}
            </span>
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            {{ $data['totalQuotes'] }}
            @if($data['totalQuotes'] > 0)
                <span class="ml-2 text-sm text-green-500 font-medium flex">
                    ↑ {{ $data['totalQuotesChange'] }}
                </span>
            @else
                <span class="ml-2 text-sm text-red-500 font-medium flex">
                    ↓ {{ $data['totalQuotesChange'] }}
                </span>
            @endif
        </p>
        <small class="text-gray-400">Comparison to last year</small>
    </div>

    <!-- Quotes This Month -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Quotes This Month
            <span class="ml-2 text-xs text-blue-600 font-medium bg-blue-50 px-2 py-1 rounded">
                {{ now()->format('F') }}
            </span>
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            {{ $data['thisMonth'] }}
            @if($data['thisMonthChange'] > 0)
                <span class="ml-2 text-sm text-green-500 font-medium flex">
                    ↑ {{ $data['thisMonthChange'] }}
                </span>
            @else
                <span class="ml-2 text-sm text-red-500 font-medium flex">
                    ↓ {{ $data['thisMonthChange'] }}
                </span>
            @endif
        </p>
        <small class="text-gray-400">vs last month</small>
    </div>

    <!-- Pending Quotes -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Pending Quotes
            <span class="ml-2 text-xs text-yellow-600 font-medium bg-yellow-50 px-2 py-1 rounded">
                High Priority
            </span>
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            {{ $data['pendingQuotes'] }}
            @if(isset($data['pendingQuotesUrgent']))
                <span class="ml-2 text-xs text-red-600 font-semibold bg-red-50 px-2 py-1 rounded">
                    Urgent!
                </span>
            @endif
        </p>
        <small class="text-gray-400">Needs attention this week</small>
    </div>
</div>
