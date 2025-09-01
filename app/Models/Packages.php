<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $guarded = []; // allow all fields to be mass assignable
    public function foods()
{
    return $this->hasMany(PackageFoods::class, 'package_id');
}
}
