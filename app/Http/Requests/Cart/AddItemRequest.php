<?php

namespace App\Http\Requests\Cart;

use App\Traits\ExceptionHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddItemRequest extends FormRequest
{
    use ExceptionHandler;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'user_id' => Rule::exists('users', 'id')->where('role_id' , 1),
            'product_id' => ['required' , Rule::exists('products' , 'id')],
            'quantity' => 'min:1'
        ];
    }
}
