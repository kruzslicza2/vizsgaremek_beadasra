<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return view('brands.index', ['brands' => $brands]);
    }

public function create()
    {
        // Admin hozzáférés
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Csak admin vehet fel új márkát.');
        }

        $brands = Brand::orderBy('name')->get();
        return view('brands.create', [
            'brands' => $brands
        ]);
    }

public function store(Request $request)
{
    if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Csak admin vehet fel új márkát.');
    }

    $request->validate([
        'name' => 'required|unique:brands',
        'country' => 'required',
        'logo' => 'nullable|image|max:2048',
        'description' => 'nullable'
    ], [
        'name.required' => 'A márkanév megadása kötelező!',
        'name.unique' => 'Ez a márkanév már létezik!',
        'country.required' => 'A származási ország megadása kötelező!',
        'logo.image' => 'A logó csak kép formátumú lehet!',
        'logo.max' => 'A logó mérete nem lehet nagyobb 2MB-nál!'
    ]);

    $brand = new Brand();
    $brand->name = $request->name;
    $brand->country = $request->country;
    $brand->description = $request->description;
    $brand->active = true;

    if ($request->hasFile('logo')) {
    $path = $request->file('logo')->store('brands', 'public');
    $brand->logo = basename($path);
    }

    $brand->save();

    return redirect()->route('brands.index')
        ->with('success', 'Márka sikeresen hozzáadva!');
}

    public function edit(Brand $brand)
    {

        // A szerkesztést is csak admin végezheti:
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Csak admin szerkesztheti a márkákat.');
        }
        return view('brands.edit', compact('brand'));
        }

    public function update(Request $request, Brand $brand)
    {
        // A frissítést is csak admin végezheti:
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Csak admin módosíthatja a márkákat.');
        }
        $validated = $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'country' => 'required',
            'active' => 'boolean'
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')
            ->with('success', 'Márka sikeresen módosítva!');
    }
    public function destroy(Brand $brand)
{
    // Esetleges ellenőrzés redundanciaként
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Nincs jogosultságod a törléshez!');
    }

    // Brand törlése
    $brand->delete();

    return redirect()->route('brands.index')->with('success', 'A márka sikeresen törölve!');
}

}
