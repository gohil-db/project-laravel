<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'designation',
        'description',
        'fb_link',
        'insta_link',
        'x_link',
        'image'
    ];
}
