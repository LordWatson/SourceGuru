<div class="bg-white overflow-hidden rounded-lg shadow-md">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Quick Actions</h3>
    </div>
    <div class="p-6 flex justify-evenly">
        <a href="{{ route('quotes.create') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            New Quote
        </a>
        <a href="{{ route('companies.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            View Companies
        </a>
        <a href="{{ route('reports.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            View Stats
        </a>
        <a href="{{ route('reports.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            Generate Report
        </a>
    </div>
</div>
