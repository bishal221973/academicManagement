<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelStudent extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    public static function rules($id = null)
    {
        return [
            'student_id' => 'required|exists:students,id',
            'hostel_id' => 'required|exists:hostels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after_or_equal:check_in_date',
            'remarks' => 'nullable|string',
            'price' => 'nullable',
            'bed_no' => 'nullable|string',
            'stay_month' => 'nullable',
            'total_amount'=>'nullable',
            'discount'=>'nullable',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
