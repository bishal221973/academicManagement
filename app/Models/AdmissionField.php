<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionField extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo(AdmissionSection::class,'admission_section_id','id');
    }
}
