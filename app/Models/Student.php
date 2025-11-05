<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            
            if (request()->has('registration_date')) {
                $student->registration_date = saveDate(request('registration_date'));
            }
            if (request()->has('birth_date')) {
                $student->birth_date = saveDate(request('birth_date'));
            }
        });

        static::updating(function ($student) {
            if (request()->has('registration_date')) {
                $student->registration_date = saveDate(request('registration_date'));
            }
            if (request()->has('birth_date')) {
                $student->birth_date = saveDate(request('birth_date'));
            }
            // $student->save();
        });

        // static::deleting(function ($advance) {
        //     if ($advance->payment_method_id) {
        //         $paymentMethod = PaymentMethod::find($advance->payment_method_id);

        //         if ($paymentMethod && $paymentMethod->opening_balance == 1) {
        //             $paymentMethod->balance += $advance->amount;
        //             $paymentMethod->save();
        //         }
        //     }
        // });
    }

    public static function rules($id = null)
    {
        return [
            'roll_number'=>'required',
            'name' => 'required',
            'registration_number' => 'required',
            'registration_date' => 'required',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'religion' => 'nullable',
            'cast' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'national_id' => 'nullable',
            'course_id' => 'required',
            'section_id' => 'nullable',
            'group_id' => 'nullable',
            'father_name' => 'nullable',
            'father_phone' => 'nullable',
            'father_education' => 'nullable',
            'father_profession' => 'nullable',
            'mother_name' => 'nullable',
            'mother_phone' => 'nullable',
            'mother_education' => 'nullable',
            'mother_profession' => 'nullable',
            'present_address' => 'nullable',
            'permanent_address' => 'nullable',
            'prev_school' => 'nullable',
            'prev_class' => 'nullable',
            'transfer_certificate' => 'nullable',
        ];
    }

    public function hostelStudent()
    {
        return $this->hasOne(HostelStudent::class, 'student_id');    }
}
