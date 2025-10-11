<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subject) {
            $position = 1;
            $last = Subject::latest()->first();
            if ($last) {
                $position = $last->position + 1;
            }
            $subject->position = $position;
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
            'course_id' => 'required',
            'name' => [
                'required',
                Rule::unique('subjects')
                    ->where(fn($query) => $query->where('course_id', request('course_id')))
                    ->ignore($id)
            ],
            'code' => 'required|unique:subjects,code,' . $id,
            'description' => 'nullable',
        ];
    }
}
