<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }
}
