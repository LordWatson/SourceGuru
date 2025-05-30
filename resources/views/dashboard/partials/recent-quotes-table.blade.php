<div class="bg-white overflow-hidden rounded-lg shadow-md mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">My Recent Quotes</h3>
    </div>
    <div class="p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-50 text-left">
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Quote ID
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Quoted By
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Company Name
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Date
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Status
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Total Sell Price
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($data['quotes'] as $quote)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 text-sm text-gray-900">
                        <a href="{{ route('quotes.show', ['quote' => $quote->id]) }}">#{{ $quote->id }}</a>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->user->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->company->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 text-sm">
                        <x-quote-status-label
                            :status="$quote->status"
                            class="{{ \App\Enums\QuoteStatusEnum::from($quote->status)->labelClass() }}"
                        >
                            {{ __( ucfirst($quote->status) ) }}
                        </x-quote-status-label>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900">£{{ number_format($quote->total_sell_price, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
