<?php

namespace App\Http\Requests\Auth;

use App\Traits\ExceptionHandler;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCredentialsRequest extends FormRequest
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
            'name' => 'required',
            'phone' =>'required|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'required|email|unique:users|regex:/^[\w\.-]+@([\w-]+\.)+[a-zA-Z]{2,}$/',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
