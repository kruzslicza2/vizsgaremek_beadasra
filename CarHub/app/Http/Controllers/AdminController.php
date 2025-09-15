<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Keresés a felhasználóknál
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        }

        // Szűrés jogosultság szerint (pl. user/admin)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        // Statisztika
        $totalUsers = User::count();
        $totalCars = Car::count();
        $totalBrands = Brand::count();

        return view('admin.dashboard', compact('users', 'totalUsers', 'totalCars', 'totalBrands'));
    }
    // Törlés
    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Az admin felhasználót nem lehet törölni.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Felhasználó sikeresen törölve.');
    }
    public function destroyCar($id)
{
    $car = Car::findOrFail($id);
    $car->delete();

    return redirect()->route('cars.index')->with('success', 'Hirdetés sikeresen törölve!');}
    public function manageCars()
{
    // Összes hirdetés lekérdezése (legújabb elöl)
    $cars = Car::with('user')->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.cars', compact('cars'));
}
public function listUsers(Request $request)
{
    $query = User::query();

    // Keresés név vagy email alapján
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Szűrés szerepkör szerint
    if ($request->filled('role')) {
        $query->where('role', $request->input('role'));
    }

    $users = $query->paginate(10);

    return view('admin.users.index', compact('users'));
}
}
