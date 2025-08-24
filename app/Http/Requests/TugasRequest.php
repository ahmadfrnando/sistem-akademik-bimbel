<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TugasRequest extends FormRequest
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
            'jadwal_id' => 'required|exists:jadwal,id',
            'judul' => 'required|string',
            'guru_id' => 'required|exists:guru,id',
            'kategori_tugas_id' => 'required|exists:ref_kategori_tugas,id',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'jadwal_id.required' => 'Jadwal harus diisi',
            'judul.required' => 'Judul harus diisi',
            'guru_id.required' => 'Guru harus diisi',
            'keterangan.required' => 'Keterangan harus diisi',
            'kategori_tugas_id.required' => 'Kategori harus diisi',
            'jadwal_id.exists' => 'Jadwal tidak ditemukan',
            'guru_id.exists' => 'Guru tidak ditemukan',
            'kategori_tugas_id.exists' => 'Kategori tidak ditemukan',
        ];
    }
}
