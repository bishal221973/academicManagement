<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelStudentFeature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function feature(){
        return $this->belongsTo(HostelFeature::class,'hostel_feature_id','id');
    }
}
