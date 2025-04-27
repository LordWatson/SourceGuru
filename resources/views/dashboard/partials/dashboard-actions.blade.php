<div class="bg-white overflow-hidden rounded-lg shadow-md">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Quick Actions</h3>
    </div>
    <div class="p-6 flex gap-4">
        <a href="{{ route('quotes.create') }}" class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            Create a New Quote
        </a>
        <a href="{{ route('companies.index') }}" class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            View Companies
        </a>
        <a href="{{ route('reports.index') }}" class="bg-slate-500 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            Generate Report
        </a>
    </div>
</div>
