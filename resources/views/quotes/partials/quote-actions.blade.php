<div class="bg-white overflow-hidden rounded-lg shadow-md">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Quote Actions</h3>
    </div>
    <div class="p-6 grid grid-cols-8 gap-4">

        <!-- Attach Proposal Action -->
        <x-edit-action
            class="text-black inline-flex items-center justify-center px-4 py-8 col-span-2 row-span-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
            x-data="{{ $quote }}"
            x-on:click.prevent="$dispatch('open-modal', 'attach-proposal')"
        >
            {{ __('Attach Proposal') }}
        </x-edit-action>

        @include('quotes.partials.attach-proposal-modal', ['quote' => $quote])

        <!-- Generate Proposal Action -->
        <a href="{{ route('companies.index') }}"
           class="inline-flex items-center justify-center px-4 py-8 col-span-2 row-span-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            Generate Proposal
        </a>

        <!-- View Signed Proposal Action -->
        @if(!$quote->proposal)
            <p
               class="inline-flex items-center justify-center px-4 py-8 col-span-2 row-span-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 line-through text-red-500 cursor-not-allowed"
            >
                View Signed Proposal
            </p>
        @else
            <a href="{{ route('reports.index') }}"
               class="inline-flex items-center justify-center px-4 py-8 col-span-2 row-span-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                View Signed Proposal
            </a>
        @endif

        <!--Generate Invoice Action -->
        <a href="{{ route('reports.index') }}"
           class="inline-flex items-center justify-center px-4 py-8 col-span-2 row-span-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            Generate Invoice
        </a>
    </div>
</div>
