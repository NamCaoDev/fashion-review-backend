<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "name" => "string",
            "description" => "string",
            'images' => 'array',
            'origin_price' => 'number',
            'current_price' => 'number',
            'material' => 'string',
            'price_symbol' => 'string',
            'product_type' => 'string',
            'in_stock' => 'boolean',
            'buy_links' => 'array',
            'brand_id' => 'uuid'
        ];
    }
}
