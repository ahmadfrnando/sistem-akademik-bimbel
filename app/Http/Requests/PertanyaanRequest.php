<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PertanyaanRequest extends FormRequest
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
            'tugas_id' => 'required|exists:tugas,tugas_id',
            'pertanyaan' => 'required|string',
            'bobot' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'pertanyaan.required' => 'Pertanyaan harus diisi.',
            'bobot.required' => 'Bobot harus diisi.',
            'bobot.numeric' => 'Bobot harus berupa angka.',
            'tugas_id.exists' => 'Tugas tidak ditemukan.',
        ];
    }
}
