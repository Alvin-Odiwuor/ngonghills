<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedemptionRequest extends FormRequest
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
            'reward_id' => 'required|exists:rewards,id',
            'points_used' => 'required|integer|min:1',
            'status' => 'required|string|in:pending,approved,rejected,used',
            'redeemed_at' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
