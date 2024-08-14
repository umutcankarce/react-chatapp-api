<?php

namespace App\Http\Requests\api\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name"     => "required|string|max:255",
            "email"    => "required|email|string|max:255|unique:clients",
            "password" => "required|string|max:16|min:7|confirmed",
        ];
    }

    public function attributes()
    {
        return [
            "name"     => "Ad Soyad",
            "email"    => "E-Posta Adresi",
            "password" => "Şifre"
        ];
    }
}
