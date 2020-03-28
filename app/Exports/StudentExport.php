<?php

namespace App\Exports;
use App\Http\Controllers\SDB;
use DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{

        protected $section_id;

        function __construct($section_id) {
                $this->section_id = $section_id;
        }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $id = $this->section_id;
        $db = SDB::db();
        $student_data = DB::table($db.'.student')->where($db.'.student.section_id',$id)->get();

        return $student_data;

    }

    public function headings(): array
    {
        return [
            'ID',
            'Password',
            'Student Name',
            'Email',
            'Phone Number',
            'Class ID',
            'Section ID',
            'Image',
            'Gender',
            'Birth Date',
            'Religion',
            'Blood Group',
            'Class Roll',
            'Father Name',
            'Mother Name',
            'Father Contact',
            'Mother Contact',
            'Father Occupation',
            'Mother Occupation',
            'Alt Eail',
            'Emergency Contact',
            'Present Address',
            'Permanent Address',
            'Device ID',
        ];
    }
}
