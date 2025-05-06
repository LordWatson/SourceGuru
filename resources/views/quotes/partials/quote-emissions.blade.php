<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-6 mb-6">
    <!-- Emission Benchmark -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Emission Benchmark
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            {{ number_format($quote->total_emission_benchmark, 2) }}kg
        </p>
    </div>

    <!-- Emission Result -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Emission Result
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            {{ number_format($quote->total_emission_result, 2) }}kg
        </p>
    </div>

    <!-- Impact -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Impact
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            @if($quote->total_emission_saving < 0)
                {{ $quote->total_emission_saving }}%
                <span class="ml-2 text-green-500 font-medium flex">
                    ↑
                </span>
            @else
                +{{ $quote->total_emission_saving }}%
                <span class="ml-2 text-red-500 font-medium flex">
                    ↓
                </span>
            @endif
        </p>
    </div>
</div>
