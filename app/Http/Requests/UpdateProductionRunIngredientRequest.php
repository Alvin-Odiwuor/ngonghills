<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductionRunIngredientRequest extends FormRequest
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
            'production_run_id' => 'required|integer|exists:production_runs,id',
            'ingredient_id' => 'required|integer|exists:ingredients,id',
            'quantity_used' => 'required|numeric|min:0.001',
            'unit_cost_at_time' => 'required|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ];
    }
}
