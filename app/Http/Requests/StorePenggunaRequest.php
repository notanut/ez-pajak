<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
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
            'nama' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:penggunas,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi',
            'nama.string' => 'Nama lengkap harus berupa teks',
            'nama.min' => 'Nama lengkap minimal 3 karakter',
            'nama.max' => 'Nama lengkap maksimal 255 karakter',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak sesuai',
            'email.unique' => 'email sudah terdaftar, masuk ke akunmu',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak cocok'
        ];
    }
}
