<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'pro_name',
        'pro_address',
        'pro_area',
        'pro_bed',
        'pro_bath',
        'pro_img',
        'type_id',
        'latitude',
        'longitude',
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'type_id');
    }
    
}
