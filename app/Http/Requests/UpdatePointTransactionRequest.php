<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePointTransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loyalty_account_id' => 'required|exists:loyalty_accounts,id',
            'sale_id' => 'nullable|exists:sales,id',
            'type' => 'required|string|in:earn,redeem,expire,adjust',
            'points' => 'required|integer|not_in:0',
            'description' => 'nullable|string|max:1000',
            'expires_at' => 'nullable|date',
        ];
    }
}
