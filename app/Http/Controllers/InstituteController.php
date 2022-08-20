<?php

namespace App\Http\Controllers;

use App\Imports\ImportUniList;
use App\Imports\InstituteListExcel;
use App\Institute;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class InstituteController extends Controller
{


    public function uploadUni(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'file' => 'required|mimes:xlsx,xls'
            ],
            [
                'file.required' => 'Ֆայլ ընտրված չէ',
                'file.mimes' => 'Ֆայլը պետք է լինի xls կամ xlsx տիպերի',
            ]
        );

        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        Excel::import(new ImportUniList,request()->file('file'));
        return back();

    }



}
