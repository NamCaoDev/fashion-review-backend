<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            "type" => "enum:local,global",
            'established_at' => "date",
            'founder' => "string",
            'addresses' => 'array',
            'logo' => 'string',
            'social_links' => 'array'
        ];
    }
}
