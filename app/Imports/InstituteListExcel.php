<?php

namespace App\Imports;

use App\Institute;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstituteListExcel implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $arr = [];
//        dd($row);
        return new Institute([
            'institute_name' => $row['buh'],
        //    'faculty_name' => $row['fac'],
          //  'institute_id' => $row[1],
        ]);
//        dd($row);
    }
}
