<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientPurchaseRequest extends FormRequest
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
            'ingredient_id' => 'required|integer|exists:ingredients,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'outlet_id' => 'required|integer|exists:outlets,id',
            'quantity' => 'required|numeric|min:0.001',
            'unit_cost' => 'required|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'purchase_date' => 'required|date',
            'invoice_number' => 'required|string|max:255',
            'notes' => 'nullable|string|max:3000',
        ];
    }
}
