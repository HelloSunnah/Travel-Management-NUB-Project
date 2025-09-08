<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageFoods extends Model
{
    protected $guarded = []; // allow mass assignment

    public function food() {
        return $this->belongsTo(Foods::class);
    }

    public function package() {
        return $this->belongsTo(Packages::class);
    }

}
