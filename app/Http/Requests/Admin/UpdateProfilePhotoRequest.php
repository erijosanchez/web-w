<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhotoRequest extends FormRequest
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
            'photo' => ['required', 'image', 'max:1024', 'mimes:jpg,jpeg,png']
        ];// max:1024 is for max file size in bytes
    }

    /** mensajes de alaerta al momento de actualizar la foto */

    public function messages()
    {
        return [
            'photo.max' => 'La foto no debe pesar más de 1MB',
            'photo.mimes' => 'La foto debe ser de tipo: jpg, jpeg o png'
        ];
    }
}
