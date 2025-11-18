<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
    use HasFactory;
     protected $fillable = [
        'fullname',
        'business_name',
        'description',
        'phone',
        'fb_link',
        'insta_link',
        'x_link',
        'image'
    ];
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}