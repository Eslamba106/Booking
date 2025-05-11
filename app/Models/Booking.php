<?php

namespace App\Models;

use App\Models\Hotel;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function booking_details()
    {
        return $this->hasOne(BookingDetails::class);
    }
    public function booking_unit()
    {
        return $this->hasOne(BookingUnits::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
    }

}
