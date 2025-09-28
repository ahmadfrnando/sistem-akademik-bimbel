<?php

namespace App\Imports;

use App\Models\OpsiPertanyaan;
use App\Models\Pertanyaan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PertanyaanImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function model(array $row)
    // {
    //     return new Pertanyaan([
    //         //
    //     ]);
    // }

    protected $tugasId;

    public function __construct($tugasId)
    {
        $this->tugasId = $tugasId;
    }

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $pertanyaan = Pertanyaan::create([
                    'tugas_id' => $this->tugasId,
                    'pertanyaan' => $row[1],
                    'bobot' => $row[7],
                ]);

                $label = ['A', 'B', 'C', 'D'];

                for ($i = 0; $i < 4; $i++) {
                    OpsiPertanyaan::create([
                        'pertanyaan_id' => $pertanyaan->id,
                        'label' => $label[$i],
                        'text' => $row[$i + 2],
                        'is_correct' => $i == $row[6] ? true : false
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function startRow(): int
    {
        return 3;
    }
}
