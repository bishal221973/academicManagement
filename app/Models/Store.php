<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required',
            'address' => 'nullable',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            $store->store_id = rand(100000,9999999);
        });
    }
}
