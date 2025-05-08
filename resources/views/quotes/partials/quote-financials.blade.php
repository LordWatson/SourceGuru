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
        </p>
    </div>

    <!-- Status Overview -->
    @php
        // map statuses and the data they display
        # TODO: move this to the enum
        $statusMapping = [
            \App\Enums\QuoteStatusEnum::Completed->value => [
                'label' => 'Completed',
                'content' => $quote->completed_date,
            ],
            \App\Enums\QuoteStatusEnum::Shipped->value => [
                'label' => 'Shipped',
                'content' => 'Shipped',
            ],
            \App\Enums\QuoteStatusEnum::Expired->value => [
                'label' => 'Expires In',
                'content' => ucfirst(\App\Enums\QuoteStatusEnum::Expired->value),
            ],
            \App\Enums\QuoteStatusEnum::Rejected->value => [
                'label' => 'Rejected',
                'content' => ucfirst(\App\Enums\QuoteStatusEnum::Rejected->value),
            ],
        ];

        // default
        $defaultStatus = [
            'label' => 'Expires In',
            'content' => $quote->expires_in . ' days',
        ];

        // get the correct block or the default one
        $statusBlock = $statusMapping[$quote->status] ?? $defaultStatus;
    @endphp

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-sm font-semibold text-gray-500 flex items-center">
            {{ $statusBlock['label'] }}
        </h3>
        <p class="mt-1 text-3xl font-bold text-{{ \App\Enums\QuoteStatusEnum::from($quote->status)->colour() }}-500 flex items-center">
            {{ $statusBlock['content'] }}
        </p>
    </div>
</div>
