<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CoursesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Course::with(['teacher', 'students'])->get()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'teacher' => $course->teacher ? $course->teacher->name : 'No teacher',
                'students_count' => $course->students->count(),
            ];
        });
    }

    public function headings(): array {
        return [
            'ID',
            'Name',
            'Teacher',
            'Students Count',
        ];
    }
}
