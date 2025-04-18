<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'image',
        'ad_url',
        'hit',
        'start_date',
        'end_date',
        'location',
    ];
}
