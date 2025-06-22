<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingUnits extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }
}
