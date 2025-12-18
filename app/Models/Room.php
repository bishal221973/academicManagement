<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Room extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    
    public static function rules($id = null)
    {
        return [
            'hostel_id' => 'required',
            'name' => [
                'required',
                Rule::unique('rooms')
                    ->where(fn($query) => $query->where('hostel_id', request('hostel_id')))
                    ->ignore($id),
            ],
            'type' => 'nullable',
            'no_of_bed' => 'nullable',
            'price' => 'required',
            'remarks' => 'nullable',
        ];
    }

     public function students()
    {
        return $this->hasMany(HostelStudent::class);
    }

    // public function hostelStudents(){

    // }

    
}
