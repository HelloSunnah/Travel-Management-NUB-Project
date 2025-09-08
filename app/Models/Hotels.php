<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotels extends Model
{
    protected $guarded = []; // allow mass assignment
  public function rooms()
    {
        return $this->hasMany(HotelRooms::class, 'hotel_id', 'id');
    }}
