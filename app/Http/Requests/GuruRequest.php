<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuruRequest extends FormRequest
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
            'nama' => 'required|string',
            'tgl_lahir' => 'required|date|before_or_equal:today',
            'alamat' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi.',
            'date' => ':attribute harus berisi tanggal yang valid.',
            'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan hari ini.',
        ];
    }
}
