<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalRequest extends FormRequest
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
            'nama_jadwal' => 'required|string',
            'jam_mulai' => 'required|time',
            'jam_selesai' => 'required|time',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'guru_id' => 'required|exists:guru,id'
        ];
    }

    public function messages()
    {
        return [
            'nama_jadwal.required' => 'Nama jadwal harus diisi',
            'jam_mulai.required' => 'Jam mulai harus diisi',
            'jam_selesai.required' => 'Jam selesai harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'keterangan.required' => 'Keterangan harus diisi',
            'guru_id.required' => 'Guru harus diisi',
            'guru_id.exists' => 'Guru tidak ditemukan',
        ];
    }
}
