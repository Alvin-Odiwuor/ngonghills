<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductionRunRequest extends FormRequest
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
        $productionRunId = optional($this->route('production_run'))->id;

        return [
            'recipe_id' => 'required|integer|exists:recipes,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity_produced' => 'required|numeric|min:0.001',
            'production_date' => 'required|date',
            'batch_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('production_runs', 'batch_number')->ignore($productionRunId),
            ],
            'notes' => 'nullable|string|max:3000',
            'produced_by' => 'required|integer|exists:users,id',
            'status' => 'required|string|in:planned,in-progress,completed,cancelled',
        ];
    }
}
