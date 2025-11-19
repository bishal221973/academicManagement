<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;


    protected $guarded=['id'];


    public static function rules($id = null)
    {
        return [
            'product_id' => 'required',
            'supplier_id' => 'required',
            'purchase_date' => 'required',
            'purchase_qty' => 'required',
        ];
    }

    protected static function boot()
    {
        parent::boot();

       

        static::created(function ($purchaseProduct) {
            $request = request();

            $product=Product::find($purchaseProduct->product_id);

            $product->update([
                'qty'=>$product->qty+(int)$request->purchase_qty
            ]);
        });
        
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
