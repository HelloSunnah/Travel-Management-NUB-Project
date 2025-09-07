<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotels;

class HotelRooms extends Model
{
    protected $guarded = []; // allow mass assignment
    public function hotel()
    {
        return $this->belongsTo(Hotels::class);
    }
}
