<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageFoods extends Model
{
    protected $guarded = []; // allow mass assignment

    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id');
    }
}
