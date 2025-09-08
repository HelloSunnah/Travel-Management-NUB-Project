<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Packages extends Model
{
    protected $guarded = []; // allow mass assignment


    public function destination(){ return $this->belongsTo(destinations::class); }
    public function hotel(){ return $this->belongsTo(Hotels::class); }
    public function room(){ return $this->belongsTo(HotelRooms::class,'room_id'); }
    public function foods(){ return $this->hasMany(PackageFoods::class); }


}

