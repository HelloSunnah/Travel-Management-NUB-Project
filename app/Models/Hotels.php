<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    protected $guarded = []; // allow mass assignment
public function destination()
{
    return $this->belongsTo(Destinations::class, 'destination_id');
}

public function rooms()
{
    return $this->hasMany(HotelRooms::class, 'hotel_id');
}

}
