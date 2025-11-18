<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'name'=>'required|unique:units,name,'.$id,
            'description'=>'nullable',
        ];
    }
}
