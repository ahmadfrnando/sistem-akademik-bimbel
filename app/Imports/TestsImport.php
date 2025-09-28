<?php

namespace App\Imports;

use App\Models\Tests;
use Maatwebsite\Excel\Concerns\ToModel;

class TestsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tests([
            'nama' => $row[0],
            'usia' => $row[1],
        ]);
    }
}
