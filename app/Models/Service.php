<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'qyt',
        'known',
        'status'
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'qyt' => 'integer',
    ];
    protected $attributes = [
        'status' => 'active',
    ];
    public function getStatusAttribute($value)
    {
        return $value === 'active' ? 'active' : 'disactive';
    }
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value === 'active' ? 'active' : 'disactive';
    }
    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '', $value);
    }
    public function getQytAttribute($value)
    {
        return number_format($value);
    }
    public function setQytAttribute($value)
    {
        $this->attributes['qyt'] = str_replace(',', '', $value);
    }
}
