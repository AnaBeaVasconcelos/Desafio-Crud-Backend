<?php

namespace App\Http\Requests\Products;

class ProductsUpdateRequest extends ProductsCreateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return ['name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|numeric',
            'is_active' => 'sometimes|boolean'
//            'category_id' => 'sometimes|numeric'
        ];
    }
}
