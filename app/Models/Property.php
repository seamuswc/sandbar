<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'size',
        'lat',
        'lng',
        'building',
        'description'
    ];
    
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }


   
}
