<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
    <!-- Sell Price -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Total Sell Price
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            £{{ number_format($quote->total_sell_price, 2) }}
        </p>
    </div>

    <!-- Buy Price -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Total Buy Price
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            £{{ number_format($quote->total_buy_price, 2) }}
        </p>
    </div>

    <!-- Revenue -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            Revenue
        </h3>
        <p class="mt-1 text-3xl font-bold text-gray-900 flex items-center">
            £{{ number_format($quote->revenue, 2) }}
            <span class="ml-2 text-sm font-medium flex {{ $quote->margin >= 15 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($quote->margin, 1) }}%
            </span>
        </p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            {{ \App\Enums\QuoteStatusEnum::from($quote->status)->statusBlock($quote)['label'] }}
        </h3>
        <p class="mt-1 text-3xl font-bold text-{{ \App\Enums\QuoteStatusEnum::from($quote->status)->colour() }}-500 flex items-center">
            {{ \App\Enums\QuoteStatusEnum::from($quote->status)->statusBlock($quote)['content'] }}
        </p>
    </div>
</div>
