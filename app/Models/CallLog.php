<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected static function rules(){
        return [
            'name'=>'required',
            'phone'=>'required',
            'follow_up_date'=>'required',
            'call_type'=>'required',
            'remarks'=>'nullable',
        ];
    }
}
