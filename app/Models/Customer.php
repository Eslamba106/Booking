<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function files()
    {
        return $this->hasMany(CustFile::class);
    }
}
