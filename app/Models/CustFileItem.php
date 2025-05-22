<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustFileItem extends Model
{
    use HasFactory;
        protected $guarded = [];

        public function related()
        {
            return $this->morphTo();
        }


     public function cust_file(){
        return $this->belongsTo(CustFile::class);
     }
}
