<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $appends = ['total_paid'];

    public function items(){
        return $this->hasMany(BillItem::class);
    }
    public function taxes()
    {
        return $this->hasMany(BillTax::class,'bill_id','id');
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function payments()
    {
        return $this->hasMany(related: Payment::class);
    }
    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function months()
    {
        return $this->hasMany(StudentTutionFee::class, 'bill_id', 'id');    }
}
