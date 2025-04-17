<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
  
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function unit_types(){
        return $this->belongsToMany(UnitType::class , 'hotels_unit_types' );
    }
}
