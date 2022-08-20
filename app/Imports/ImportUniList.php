<?php

namespace App\Imports;

use App\Institute;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportUniList implements ToCollection
{
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row)
        {
            if($row[0] !== '') {
                $data[] = array(
                    'institute_name'  => $row[0]
                );
            }
        }
        DB::table('institute')->insert($data);
    }
}
