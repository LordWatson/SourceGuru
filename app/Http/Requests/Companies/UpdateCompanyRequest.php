<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'primary_contact_name' => 'sometimes|string|max:255',
            'primary_contact_email' => 'sometimes|email|max:255',
            'address' => 'sometimes|string|max:255',
            'primary_contact_phone' => 'sometimes|integer',
            'account_manager_id' => 'sometimes|exists:users,id',
        ];
    }
}
