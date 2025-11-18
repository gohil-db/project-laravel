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
        'builder_id',
        'latitude',
        'longitude',
        'for_sell',
        'for_rent',
        'featured',
        'catalog',
        'description',
        'display_top',
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'type_id');
    }
    
    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function videos()
    {
        return $this->hasMany(PropertyVideo::class);
    }
    
}
