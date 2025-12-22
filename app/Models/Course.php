<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $position=1;
            $last=Course::latest()->first();
            if($last){
                $position=$last->position+1;
            }
             $course->position = $position;
            
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
            'name' => 'required|unique:courses,name,'.$id,
            'code' => 'required|unique:courses,code,' . $id,
            'fees'=>'required',
            'description' => 'nullable',
        ];
    }

    public function students(){
        return $this->hasMany(Student::class);
    }
}
