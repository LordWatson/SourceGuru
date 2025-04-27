<?php

namespace App\Http\Requests\Quotes;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteRequest extends FormRequest
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
            'company_id' => 'required|exists:companies,id',
            'quote_name' => 'required|string|max:255',
            'completed_date' => 'nullable|date',
            'expired_date' => 'nullable|date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            //'tax' => 'required|numeric|min:0'
        ];
    }
}
