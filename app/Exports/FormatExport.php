<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FormatExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection([

        ]);
    }

    public function headings(): array
    {
        return ['Roll Number', 'Student Name', 'Registration Number','Registration Date','Birth Date','Gender','Religion','Cast','Phone','Email','National ID','Group','Father Name','Father Phone','Father Education','Father Profession','Mother Name','Mother Phone','Mother Education','Mother Profession','Present Address','Permanent Address','Prev School','Prev Class'];
    }
}
