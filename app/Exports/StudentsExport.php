<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::select('id', 'name', 'email', 'age', 'course')->get();
    }

    public function headings(): array {
        return [
            'ID',
            'Name',
            'Email',
            'Age',
            'Course',
        ];
    }
}
