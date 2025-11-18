<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id=null){
        return[
            'product_code'=>'required|unique:products,product_code,'.$id,
            'product'=>'required|unique:products,product,'.$id,
            'product_category_id'=>'required',
            'unit_id'=>'required',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->qty = 0;
        });
    }

    public function category(){
        return $this->belongsTo(ProductCategory::class,'product_category_id','id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id','id');
    }
}
