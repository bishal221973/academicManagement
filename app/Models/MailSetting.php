<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules(){
        return[
            'mailer'=>'required',
            'host'=>'required',
            'port'=>'required',
            'username'=>'required',
            'password'=>'required',
            'encryption'=>'required',
            'from_address'=>'required',
            'from_name'=>'required',
        ];
    }
}
