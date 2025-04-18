<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'website_name',
        'website_image',
        'logo',
        'facebook',
        'instgram',
        'whatsapp',
        'phone',
        'mobile',
        'titles',
        'images',
    ];
}
