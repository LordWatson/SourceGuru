<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul class="divide-y divide-gray-200">
                        @foreach($companies as $company)
                            <li class="py-4 flex items-center justify-between hover:bg-gray-100">
                                <div class="flex items-center">
                                    <!-- User Avatar -->
                                    <div class="w-10 h-10 rounded-full bg-gray-400 flex justify-center items-center text-white mr-4">
                                        {{ strtoupper(substr($company->name, 0, 1)) }}
                                    </div>
                                    <!-- User Info -->
                                    <div>
                                        <p class="text-lg font-medium text-gray-800">
                                            <a href="{{ route('companies.show', ['company' => $company->id]) }}">
                                                {{ $company->name }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ ucwords($company->accountManager->name) }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Quote Count -->
                                <div class="text-right">
                                    <p class="text-base font-semibold text-gray-700">{{ count($company->quotes) }}</p>
                                    <p class="text-sm text-gray-500">Quotes</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-4">
                {{-- Render pagination links --}}
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
