<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactImport implements ToCollection,WithHeadingRow, WithBatchInserts
{
    public $data;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $row)
    {
        $this->data = $row;
    }

    /**
     * Determine batch size of uploaded csv
     *
     * @return int
     */
    public function batchSize(): int {
        return 1000;
    }
}
