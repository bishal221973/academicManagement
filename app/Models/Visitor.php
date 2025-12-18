<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected static function rules(){
        return [
            'name'=>'required',
            'phone'=>'required',
            'date'=>'required',
            'in_time'=>'required',
            'out_time'=>'required',
            'purpose'=>'required',
        ];
    }
}
