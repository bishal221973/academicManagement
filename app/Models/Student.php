<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

     protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'registration_number' => 'required',
            'registration_date' => 'required',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'religion' => 'nullable',
            'cast' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'national_id' => 'nullable',
            'course_id' => 'required',
            'section_id' => 'required',
            'group_id' => 'nullable',
            'father_name' => 'nullable',
            'father_phone' => 'nullable',
            'father_education' => 'nullable',
            'father_profession' => 'nullable',
            'mother_name' => 'nullable',
            'mother_phone' => 'nullable',
            'mother_education' => 'nullable',
            'mother_profession' => 'nullable',
            'present_address' => 'nullable',
            'permanent_address' => 'nullable',
            'prev_school' => 'nullable',
            'prev_class' => 'nullable',
            'transfer_certificate' => 'nullable',
        ];
    }
}
