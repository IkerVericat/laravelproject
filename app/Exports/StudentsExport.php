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
        return Student::with('course')->get()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'age' => $student->age,
                'course' => $student->course ? $student->course->name : 'Sin curso',
            ];
        });
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
