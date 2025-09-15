<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = ['name', 'brand_id', 'active'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
{
    return $this->hasMany(CarImage::class);
}
}
