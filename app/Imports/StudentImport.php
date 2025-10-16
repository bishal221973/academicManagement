<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Group;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    protected $courseId;
    protected $sectionId;

    protected $courseMap;
    protected $sectionMap;
    protected $groupMap;
    public function __construct($courseId, $sectionId = null)
    {
        $this->courseId = $courseId;
        $this->sectionId = $sectionId;

        $this->courseMap = Course::pluck('id', 'name')->toArray();
        $this->sectionMap = Section::pluck('id', 'name')->toArray();
        $this->groupMap = Group::pluck('id', 'name')->toArray();
    }

    
    public function collection(Collection $rows)
{
    foreach ($rows as $index => $row) {
        // ❗ Skip header row
        if ($index === 0) {
            continue;
        }

        // ✅ Safe checks for required fields
        if (!isset($row[0], $row[1], $row[2], $row[3])) {
            continue;
        }

        $courseId = $this->courseMap[trim($this->courseId)] ?? null;
        $sectionId = $this->sectionMap[trim($this->sectionId)] ?? null;
        $groupId = $this->groupMap[trim($row[11] ?? '')] ?? null;

        $student = new Student([
            'roll_number' => $row[0] ?? null,
            'name' => $row[1] ?? null,
            'registration_number' => $row[2] ?? null,
            'registration_date' => (string) trim($row[3] ?? ''),
            'birth_date' => $row[4] ?? null,
            'gender' => $row[5] ?? null,
            'religion' => $row[6] ?? null,
            'cast' => $row[7] ?? null,
            'phone' => $row[8] ?? null,
            'email' => $row[9] ?? null,
            'national_id' => $row[10] ?? null,
            'course_id' => $this->courseId,
            'section_id' => $this->sectionId,
            'group_id' => $groupId,
            'father_name' => $row[12] ?? null,
            'father_phone' => $row[13] ?? null,
            'father_education' => $row[14] ?? null,
            'father_profession' => $row[15] ?? null,
            'mother_name' => $row[16] ?? null,
            'mother_phone' => $row[17] ?? null,
            'mother_education' => $row[18] ?? null,
            'mother_profession' => $row[19] ?? null,
            'present_address' => $row[20] ?? null,
            'permanent_address' => $row[21] ?? null,
            'prev_school' => $row[22] ?? null,
            'prev_class' => $row[23] ?? null,
        ]);

        $student->save();
    }
}

}
