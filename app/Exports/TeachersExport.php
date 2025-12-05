<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Teacher::select('id', 'name', 'email', 'subject', 'phone')->get();
    }

    public function headings(): array {
        return [
            'ID',
            'Name',
            'Email',
            'Subject',
            'Phone',
        ];
    }
}
