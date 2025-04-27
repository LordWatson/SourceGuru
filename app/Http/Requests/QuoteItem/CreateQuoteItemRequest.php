<?php

namespace App\Http\Requests\QuoteItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'quote_id' => 'required|exists:quotes,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_source' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_buy_price' => 'required|numeric|min:0',
            'unit_sell_price' => 'required|numeric|min:0',
        ];
    }
}
