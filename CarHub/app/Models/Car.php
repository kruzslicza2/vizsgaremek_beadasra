<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
protected $fillable = [
    'user_id','marka','modell','evjarat','ar','leiras','kep','uzemanyag',
    'km_ora','teljesitmeny','valto','szin','karosszeria','extrak'
];

public function user() {
    return $this->belongsTo(User::class);
}

public function images() {
    return $this->hasMany(CarImage::class);
}

// Ez az új kód amit hozzá kell adni:
protected static function boot()
{
    parent::boot();

    static::deleting(function($car) {
        foreach($car->images as $image) {
            // Töröljük a fájlt a storage-ból
            Storage::disk('public')->delete('cars/' . $image->path);
        }
        // Töröljük a kapcsolódó képeket az adatbázisból
        $car->images()->delete();
    });
}
}
