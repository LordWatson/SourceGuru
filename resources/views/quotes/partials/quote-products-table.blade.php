<div class="bg-white overflow-hidden rounded-lg shadow-md mb-6">
    <div class="px-6 py-4 border-b">
        <h3 class="font-semibold text-lg text-gray-800">Products</h3>
    </div>
    <div class="p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-50 text-left">
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Name
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Description
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Source
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Quantity
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Unit Buy
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Unit Sell
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Total Buy
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Total Sell
                </th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($quote->products as $product)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $product->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ \Illuminate\Support\Str::words($product->description, 3, '...') }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $product->product_source }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $product->quantity }}</td>
                    <td class="px-4 py-2 text-sm">£{{ number_format($product->unit_buy_price, 2) }}</td>
                    <td class="px-4 py-2 text-sm">£{{ number_format($product->unit_sell_price, 2) }}</td>
                    <td class="px-4 py-2 text-sm">£{{ number_format($product->total_buy_price, 2) }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">£{{ number_format($product->total_sell_price, 2) }}</td>
                    <td class="px-4 py-2 text-sm">
                        <p>
                            <x-edit-action
                                x-data="{{ $product }}"
                                x-on:click.prevent="$dispatch('open-modal', 'edit-quote-item-{{ $product->id }}')"
                            >
                                {{ __('Edit') }}
                            </x-edit-action>
                            <span class="text-gray-400">|</span>
                            <x-duplicate-action
                                x-data="{{ $product }}"
                                x-on:click.prevent="$dispatch('open-modal', 'duplicate-quote-item-{{ $product->id }}')"
                            >
                                {{ __('Duplicate') }}
                            </x-duplicate-action>
                            <span class="text-gray-400">|</span>
                            <x-delete-action
                                x-data="{{ $product }}"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-quote-items-deletion-{{ $product->id }}')"
                            >
                                {{ __('Delete') }}
                            </x-delete-action>

                            @include('quotes.partials.edit-quote-item-modal', ['product' => $product])

                            @include('quotes.partials.duplicate-quote-item-modal', ['product' => $product])

                            @include('quotes.partials.delete-quote-item-modal', ['product' => $product])
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Add Product Link -->
        <div class="mt-4">
            <x-edit-action
                x-data="{{ $quote }}"
                x-on:click.prevent="$dispatch('open-modal', 'add-quote-item')"
            >
                {{ __('+ Add Product') }}
            </x-edit-action>

            @include('quotes.partials.add-product-or-package-modal', ['quoteId' => $quote->id])

            @include('quotes.partials.add-quote-item-modal', ['quoteId' => $quote->id])
            @include('quotes.partials.add-catalogue-product-modal', ['quoteId' => $quote->id])
        </div>
    </div>
</div>
