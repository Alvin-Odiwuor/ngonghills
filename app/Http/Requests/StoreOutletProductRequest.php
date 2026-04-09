<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOutletProductRequest extends FormRequest
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
            'outlet_id' => 'required|integer|exists:outlets,id',
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('outlet_products', 'product_id')->where(fn ($query) => $query->where('outlet_id', $this->input('outlet_id'))),
            ],
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
