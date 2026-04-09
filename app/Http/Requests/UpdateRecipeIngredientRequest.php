<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeIngredientRequest extends FormRequest
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
            'recipe_id' => 'required|integer|exists:recipes,id',
            'ingredient_id' => 'required|integer|exists:ingredients,id',
            'quantity_required' => 'required|numeric|min:0.001',
            'unit' => 'required|string|in:g,ml,kg,L,pcs',
            'notes' => 'nullable|string|max:3000',
        ];
    }
}
