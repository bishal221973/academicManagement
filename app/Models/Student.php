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
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function bills(){
        return $this->hasMany(Bill::class);
    }

    public function hostels(){
        return $this->hasMany(HostelStudent::class);
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

        static::created(function ($student) {
            $request = request();

            if ($request instanceof \Illuminate\Http\Request) {
                $sub_total = $request->input('sub_total', 0);
                $net_total = $request->input('net_total', 0);
                $total_amount = $request->input('total_amount', 0);
                $discount = $request->input('discount', 0);
                $admission_fees = $request->input('admition_fees', 0);
                $tution_fees = $request->input('tution_fees', 0);

                $taxes = $request->input('taxes', []);
            } else {
                $sub_total = rand(500, 1000);
                $net_total = $sub_total - rand(0, 100);
                $total_amount = $net_total;
                $discount = rand(0, 50);
                $admission_fees = rand(00000, 999999);
                $tution_fees = 0;
                $taxes = [];
            }

            $billing = $student->billings()->create([
                'student_id' => $student->id,
                'academic_year_id' => $student->academic_year_id,
                'bill_no' => rand(0000000, 999999) . $student->id,
                'sub_total' => $sub_total ?? 0,
                'net_total' => $net_total,
                'total_tax' => 0,
                'total_amount' => $total_amount,
                'discount' => $discount,
            ]);

            $bill = BillItem::create([
                'student_id' => $student->id,
                'academic_year_id' => $student->academic_year_id,
                'bill_id' => $billing->id,
                'title' => 'Admisstion Fees',
                'amount' => $admission_fees ?? 0,
            ]);

            if ($tution_fees > 0) {
                BillItem::create([
                    'student_id' => $student->id,
                    'academic_year_id' => $student->academic_year_id,
                    'bill_id' => $billing->id,
                    'title' => 'Tution Fees',
                    'amount' => $tution_fees ?? 0,
                ]);
            }

            foreach ($taxes as $tax) {
                BillTax::create([
                    'student_id' => $student->id,
                    'academic_year_id' => $student->academic_year_id,
                    'bill_id' => $billing->id,
                    'percentage' => $tax['percentage'],
                    'amount' => $total_amount * $tax['percentage'] / 100,
                ]);
            }

            notifyMail($student->email,$student->id,$billing->id,'Admission Mail');
            // notifyMail($student->email,$student->id,'Bill Generated Mail');
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

    public function billings()
    {
        return $this->hasMany(Bill::class);
    }

    public static function rules($id = null)
    {
        return [
            'roll_number' => 'required',
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
            'group_id' => 'required',
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
            'admition_fees' => 'nullable',
        ];
    }

    public function hostelStudent()
    {
        return $this->hasOne(HostelStudent::class, 'student_id');
    }

    public function hostelStudents()
    {
        return $this->hasMany(HostelStudent::class, 'student_id');
    }

    public function studentTuitionFees()
    {
        return $this->hasMany(StudentTutionFee::class);
    }
}
