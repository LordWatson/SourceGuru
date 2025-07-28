<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // check the user is of admin level
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id',
            'product_sub_type_id' => 'required|exists:product_sub_types,id',
            'unit_buy_price' => 'required|numeric|min:0',
            'unit_sell_price' => 'required|numeric|min:0',
            'source' => 'required|string|max:255',
        ];
    }
}
