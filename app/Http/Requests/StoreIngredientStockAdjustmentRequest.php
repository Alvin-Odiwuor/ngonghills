<?php

namespace App\Http\Requests;

use App\Models\IngredientPurchase;
use App\Models\ProductionRun;
use Illuminate\Foundation\Http\FormRequest;

class StoreIngredientStockAdjustmentRequest extends FormRequest
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
            'adjustment_type' => 'required|string|in:addition,deduction',
            'quantity' => 'required|numeric|min:0.001',
            'reason' => 'required|string|in:purchase,wastage,spoilage,correction,return',
            'reference_type' => 'nullable|string|in:' . IngredientPurchase::class . ',' . ProductionRun::class,
            'reference_id' => [
                'nullable',
                'integer',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $referenceType = $this->input('reference_type');

                    if ($referenceType && !$value) {
                        $fail('The reference id is required when reference type is selected.');
                        return;
                    }

                    if (!$referenceType && $value) {
                        $fail('The reference type is required when reference id is provided.');
                        return;
                    }

                    if (!$referenceType || !$value) {
                        return;
                    }

                    if ($referenceType === IngredientPurchase::class && !IngredientPurchase::query()->whereKey($value)->exists()) {
                        $fail('The selected ingredient purchase reference does not exist.');
                    }

                    if ($referenceType === ProductionRun::class && !ProductionRun::query()->whereKey($value)->exists()) {
                        $fail('The selected production run reference does not exist.');
                    }
                },
            ],
            'notes' => 'nullable|string|max:3000',
            'adjusted_by' => 'required|integer|exists:users,id',
        ];
    }
}
