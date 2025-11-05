<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'address' => 'nullable',
            'type' => 'nullable',
            'remarks' => 'nullable',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function students()
    {
        return $this->hasMany(HostelStudent::class);
    }
}
