<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalDispatch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function rules(){
        return [
            'to_title'=>'required',
            'from_title'=>'required',
            'reference'=>'required',
            'phone_number'=>'required',
            'date'=>'required',
            'remarks'=>'nullable',
        ];
    }
}
