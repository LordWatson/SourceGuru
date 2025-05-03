<div style="max-height: 700px;" class="overflow-y-auto overflow-x-auto" id="quotes-table-div">
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
                Company
            </th>
            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                Quoted By
            </th>
            <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                Created
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
                <td class="px-4 py-2 text-sm text-gray-900">
                    <a href="{{ route('companies.show', ['company' => $quote->company->id]) }}">{{ $quote->company->name }}</a>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">
                    <a href="{{ route('users.show', ['user' => $quote->user->id]) }}">{{ $quote->user->name }}</a>
                </td>
                <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->created_at->format('Y-m-d') }}</td>
                <td class="px-4 py-2 text-sm">
                    <x-quote-status-label
                        :status="$quote->status"
                        class="bg-{{ \App\Enums\QuoteStatusEnum::from($quote->status)->colour() }}-100 text-{{ \App\Enums\QuoteStatusEnum::from($quote->status)->colour() }}-800"
                    >
                        {{ __(ucfirst($quote->status)) }}
                    </x-quote-status-label>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Loading Spinner for infinite scrolling --}}
<div id="loading-more" class="text-center py-4 hidden">
    <span class="text-gray-600">Loading more...</span>
</div>

<script>
    const CURRENT_PAGE_PLACEHOLDER = {{ $quotes->currentPage() }};
    const LAST_PAGE_PLACEHOLDER = {{ $quotes->lastPage() }};
</script>
