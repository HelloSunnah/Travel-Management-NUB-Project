<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageFoods extends Model
{
    protected $guarded = []; // allow mass assignment

    public function package()
    {
        return $this->belongsTo(Packages::class, 'package_id', 'id'); // <-- must match table column
    }

    public function food()
    {
        return $this->belongsTo(Foods::class, 'food_id', 'id');
    }

}
