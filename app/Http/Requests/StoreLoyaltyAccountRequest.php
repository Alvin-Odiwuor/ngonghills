<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoyaltyAccountRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id|unique:loyalty_accounts,customer_id',
            'points_balance' => 'required|integer|min:0',
            'total_points_earned' => 'required|integer|min:0',
            'total_points_redeemed' => 'required|integer|min:0|lte:total_points_earned',
            'tier' => 'required|string|in:Bronze,Silver,Gold',
            'status' => 'required|string|in:active,suspended',
        ];
    }
}
