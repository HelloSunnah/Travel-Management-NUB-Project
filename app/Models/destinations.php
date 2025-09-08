<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class destinations extends Model
{
    protected $guarded = []; // allow mass assignment
    public function foods()
{
    return $this->hasMany(\App\Models\Foods::class, 'destination_id');
}
}
