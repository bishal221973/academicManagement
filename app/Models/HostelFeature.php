<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelFeature extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected static function rules(){
        return[
            'title'=>'required',
            'price'=>'required',
            'description'=>'nullable',
        ];
    }
}
