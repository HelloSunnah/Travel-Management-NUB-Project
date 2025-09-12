<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Packages extends Model
{
    protected $guarded = []; // allow mass assignment


public function destination()
{
    return $this->belongsTo(Destinations::class, 'destination_id');
}

public function hotel()
{
    return $this->belongsTo(Hotels::class, 'hotel_id');
}

public function room()
{
    return $this->belongsTo(HotelRooms::class, 'room_id');
}

public function foods()
{
    return $this->hasMany(packageFoods::class, 'package_id');
}

}

