<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'name'=>'required|unique:suppliers,name,'.$id,
            'email'=>'nullable',
            'phone'=>'nullable',
            'vat_no'=>'nullable',
            'address'=>'nullable',
            'description'=>'nullable',
        ];
    }

}
