<div class="bg-white overflow-hidden rounded-lg shadow-md mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Quotes</h3>
    </div>
    <div class="p-6">
        <div class="max-h-96 overflow-y-auto overflow-x-auto">
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
                    @php
                        $class = '';
                        if (in_array($quote->status, ['accepted', 'completed'])) {
                            $class = 'bg-green-100 text-green-800';
                        } elseif (in_array($quote->status, ['rejected', 'expired'])) {
                            $class = 'bg-red-100 text-red-800';
                        } elseif (in_array($quote->status, ['sent', 'draft'])) {
                            $class = 'bg-yellow-100 text-yellow-800';
                        }
                    @endphp
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-900">#{{ $quote->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->quote_name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->user->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $quote->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-2 text-sm">
                            <x-quote-status-label :status="$quote->status" :class="$class">
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

{{-- Scrollable Pagination Script --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let currentPage = {{ $quotes->currentPage() }};
        const lastPage = {{ $quotes->lastPage() }};
        const container = document.getElementById('quotes-container');

        const loadMoreQuotes = async () => {
            // no more pages to load
            if (currentPage >= lastPage) return;

            document.getElementById('loading-more').classList.remove('hidden');

            try {
                currentPage++;
                const response = await axios.get(`?page=${currentPage}`);
                const quotes = response.data.quotes.data;

                // append quotes to the table
                quotes.forEach((quote) => {
                    const row = `
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-900">#${quote.id}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.quote_name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.user.name}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">${quote.created_at}</td>
                        <td class="px-4 py-2 text-sm">
                            <x-quote-status-label class="px-2 py-1 rounded ${getStatusClass(quote.status)}" style="text-transform: capitalize;">${quote.status}</x-quote-status-label>
                        </td>
                    </tr>
                `;
                    container.insertAdjacentHTML('beforeend', row);
                });
            } catch (error) {
                console.error('Error loading more quotes:', error);
            } finally {
                document.getElementById('loading-more').classList.add('hidden');
            }
        };

        const getStatusClass = (status) => {
            if (['accepted', 'completed'].includes(status)) {
                return 'bg-green-100 text-green-800';
            } else if (['rejected', 'expired'].includes(status)) {
                return 'bg-red-100 text-red-800';
            } else {
                return 'bg-yellow-100 text-yellow-800';
            }
        };

        // event listener for infinite scroll
        window.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 50) {
                loadMoreQuotes();
            }
        });
    });
</script>
