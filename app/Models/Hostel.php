<?php

namespace App\Models;

use Carbon\Carbon;
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
    public function currentStudents()
    {
        return $this->hasMany(HostelStudent::class)
        ->whereDate('check_out_date', '>', Carbon::today());
    }
}
