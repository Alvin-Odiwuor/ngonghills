<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
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
            'product_id' => 'required|integer|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:3000',
            'yield_quantity' => 'required|numeric|min:0.001',
            'notes' => 'nullable|string|max:3000',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
