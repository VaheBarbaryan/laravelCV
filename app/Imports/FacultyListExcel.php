<?php

namespace App\Imports;

use App\Faculty;
use Maatwebsite\Excel\Concerns\ToModel;

class FacultyListExcel implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Faculty([
            //    'faculty_name' => $row['fac'],
            //  'institute_id' => $row[1],
        ]);
    }
}
