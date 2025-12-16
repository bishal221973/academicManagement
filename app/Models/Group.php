<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public static function rules($id = null)
    {
        return [
            'name' => 'required|unique:groups,name,' . $id,
            'parent_id'=>'nullable',
            'description' => 'nullable',
        ];
    }

    public function children()
{
    return $this->hasMany(Group::class, 'parent_id');
}

public function parent()
{
    return $this->belongsTo(Group::class, 'parent_id');
}
}
