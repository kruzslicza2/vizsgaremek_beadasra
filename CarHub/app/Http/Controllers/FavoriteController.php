<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('car')->get();
        return view('favorites.index', ['favorites' => $favorites]);
    }

    public function toggle(Car $car)
    {
        $user = Auth::user();
        $existing = $user->favorites()->where('car_id', $car->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Hirdetés törölve a kedvencekből!';
        } else {
            $user->favorites()->create([
                'car_id' => $car->id
            ]);
            $message = 'Hirdetés hozzáadva a kedvencekhez!';
        }

        return back()->with('success', $message);
    }
}
