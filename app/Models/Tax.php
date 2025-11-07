<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'name'=>'required|unique:taxes,name,'.$id,
            'percentage'=>'required',
        ];
    }
}
