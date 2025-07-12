<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products Types') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Product Types List -->
                    <ul x-data="{ openTypeIndex: null }" class="divide-y divide-gray-200">
                        @foreach($productTypes as $index => $productType)
                            <li class="py-4">
                                <!-- Product Type -->
                                <div
                                    @click="openTypeIndex = openTypeIndex === {{ $index }} ? null : {{ $index }}"
                                    class="cursor-pointer flex items-center justify-between hover:bg-gray-100 px-4 py-2"
                                >
                                    <p class="text-lg font-medium text-gray-800">
                                        {{ $productType->name }}
                                    </p>
                                    <span class="text-gray-500" x-show="openTypeIndex !== {{ $index }}">+</span>
                                    <span class="text-gray-500" x-show="openTypeIndex === {{ $index }}">-</span>
                                </div>

                                <!-- Product SubTypes -->
                                <ul x-show="openTypeIndex === {{ $index }}" class="ml-4 divide-y divide-gray-200" x-collapse>
                                    @foreach($productType->subTypes as $productSubType)
                                        <li class="py-2 flex items-center justify-between hover:bg-gray-100">
                                            <!-- Product SubType -->
                                            <div class="cursor-pointer flex items-center justify-between px-4 py-2 w-full">
                                                <p class="text-base font-medium text-gray-800">
                                                    {{ $productSubType->name }}
                                                </p>
                                                <!-- Count of Products -->
                                                <span class="text-sm text-gray-500">
                                                    {{ count($productSubType->products) }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
