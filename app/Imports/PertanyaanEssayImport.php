<?php

namespace App\Imports;

use App\Models\Pertanyaan;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;

class PertanyaanEssayImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $tugasId;

    public function __construct($tugasId)
    {
        $this->tugasId = $tugasId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pertanyaan::create([
                'tugas_id' => $this->tugasId,
                'pertanyaan' => $row[1],
                'bobot' => $row[2],
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
