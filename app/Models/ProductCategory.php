<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

     protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required|unique:product_categories,name,'.$id,
            'description' => 'nullable',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($store) {
            $store->category_id = rand(100000,9999999);
        });
    }
}
