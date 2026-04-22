<?php

namespace App\Http\Requests\Product;

// use Illuminate\Contracts\Validation\ValidationRule;
use App\Traits\ExceptionHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    use ExceptionHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'price' => 'required',
            'quantity_in_stock' => 'required|int',
            'category_id' =>['required' , Rule::exists('categories', 'id')],
            'vendor_id' => Rule::exists('users', 'id')
        ];
    }
}
