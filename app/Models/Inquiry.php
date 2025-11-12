<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'name', 'number', 'city'];
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
