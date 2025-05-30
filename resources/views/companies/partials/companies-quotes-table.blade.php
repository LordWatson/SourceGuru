<div class="bg-white overflow-hidden rounded-lg shadow-md mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Quotes</h3>
    </div>
    <div class="p-6" id="quotes-table">
        <div class="max-h-96 overflow-y-auto overflow-x-auto" id="quotes-table-div">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                <tr class="bg-gray-50 text-left">
                    <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                        Quote ID
                    </th>
                    <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                        Quote Name
                    </th>
                    <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                        Quoted By
                    </th>
                    <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                        Date
                    </th>
                    <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                        Status
                    </th>
                </tr>
                </thead>
                <tbody id="quotes-container" class="bg-white divide-y divide-gray-200">
                @foreach($quotes as $quote)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-900">
                            <a href="{{ route('quotes.show', ['quote' => $quote->id]) }}">#{{ $quote->id }}</a>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->quote_name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->user->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 text-sm">
                            <x-quote-status-label
                                :status="$quote->status"
                                class="{{ \App\Enums\QuoteStatusEnum::from($quote->status)->labelClass() }}"
                            >
                                {{ __(ucfirst($quote->status)) }}
                            </x-quote-status-label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Loading Spinner for infinite scrolling --}}
<div id="loading-more" class="text-center py-4 hidden">
    <span class="text-gray-600">Loading more...</span>
</div>

<script>
    const CURRENT_PAGE_PLACEHOLDER = {{ $quotes->currentPage() }};
    const LAST_PAGE_PLACEHOLDER = {{ $quotes->lastPage() }};
</script>
@vite(['resources/js/companies-quotes-table.js'])
