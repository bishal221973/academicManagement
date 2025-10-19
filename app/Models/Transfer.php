<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'student_id'=>'required',
            'school_name'=>'nullable',
            'reason'=>'nullable',
            'section_id'=>'nullable',
            'course_id'=>'nullable'
        ];
    }
}
