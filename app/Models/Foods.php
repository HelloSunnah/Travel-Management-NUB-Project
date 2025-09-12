<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    protected $guarded = []; // allow mass assignment

    public function packages() {
        return $this->hasMany(packageFoods::class);
    }
    public function destination()
{
    return $this->belongsTo(Destinations::class, 'destination_id');
}

}
