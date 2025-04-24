<div class="bg-white overflow-hidden rounded-lg shadow-md mb-6">
    <header>
        <div class="px-6 py-4">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Products') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Add, Edit, or Remove products to this quote") }}
            </p>
        </div>
    </header>
    <div class="px-6 py-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
            <tr class="bg-gray-50 text-left">
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Name</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Description</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Source</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Quantity</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Unit Buy Price</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Unit Sell Price</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Total Buy Price</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Total Sell Price</th>
                <th scope="col" class="px-4 py-2 text-sm text-gray-500 font-medium">Action</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($quote->products as $product)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2">
                        <input type="text" name="products[{{ $loop->index }}][name]" value="{{ $product->name }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="products[{{ $loop->index }}][description]" value="{{ $product->description }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="products[{{ $loop->index }}][product_source]" value="{{ $product->product_source }}" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $product->quantity }}" step="1" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="number" name="products[{{ $loop->index }}][unit_buy_price]" value="{{ $product->unit_buy_price }}" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="number" name="products[{{ $loop->index }}][unit_sell_price]" value="{{ $product->unit_sell_price }}" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <p>£{{ number_format($product->total_buy_price, 2) }}</p>
                    </td>
                    <td class="px-4 py-2">
                        <p>£{{ number_format($product->total_sell_price, 2) }}</p>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button type="button" class="text-red-600 hover:text-red-800" onclick="removeProductRow({{ $loop->index }})">Remove</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="9" class="px-4 py-2">
                    <p class="text-blue-600 cursor-pointer" onclick="addProductRow()">
                        Add Product
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
