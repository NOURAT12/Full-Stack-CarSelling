<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory,ImageTrait;
    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'price',
        'carimages',
        'description',
        'sold',
        'color',
        'city',
        'country',
    ];
    public $appends=[
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return $this->getImage($this->path);
    }
}
