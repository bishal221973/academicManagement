<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    use HasFactory;

     protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'name'=>'required|unique:payment_modes,name,'.$id,
            'description'=>'nullable',
        ];
    }
}
