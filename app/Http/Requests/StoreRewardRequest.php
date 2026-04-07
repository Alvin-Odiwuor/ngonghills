<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRewardRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'points_required' => 'required|integer|min:1',
            'reward_type' => 'required|string|in:discount,free_product,voucher',
            'reward_value' => 'nullable|string|max:255',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'expires_at' => 'nullable|date',
        ];
    }
}
