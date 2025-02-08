<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            //
            "name" => "string|required",
            "description" => "string",
            'images' => 'array',
            'origin_price' => 'numeric|required',
            'current_price' => 'numeric|required',
            'material' => 'string',
            'price_symbol' => 'string',
            'product_type' => 'string|required',
            'in_stock' => 'boolean|required',
            'buy_links' => 'array',
            'brand_id' => 'uuid|required'
        ];
    }
}
