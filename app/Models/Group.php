<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'description' => 'nullable',
        ];
    }
}
