<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
        protected $guarded = [];

       public function category() {
        return $this->belongsTo(CarCategory::class);
    }
       public function tour() {
        return $this->belongsTo(Tour::class);
    }
        public function customer() {
             return $this->belongsTo(Customer::class);
     }
}
