<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function show(Car $car)
    {
        // Itt csak egy autót mutatunk meg
        return view('cars.show', ['car' => $car]);
    }

public function index(Request $request)
{
    $query = Car::query();
    $brands = Brand::where('active', true)->orderBy('name')->get();

    // Szűrés gyártóra
    if ($request->has('marka') && $request->marka != '') {
        $query->where('marka', $request->marka);
    }
        // Modell szűrés
        if ($request->has('modell') && $request->modell != '') {
            $query->where('modell', 'like', '%' . $request->modell . '%');
        }
        // Évjárat szűrés
        if ($request->has('evjarat_from') && $request->evjarat_from != '') {
        $query->where('evjarat', '>=', $request->evjarat_from);
    }
    if ($request->has('evjarat_to') && $request->evjarat_to != '') {
        $query->where('evjarat', '<=', $request->evjarat_to);
    }
        // Ár szűrés
        if ($request->has('ar_tol') && $request->ar_tol != '') {
            $query->where('ar', '>=', $request->ar_tol);
        }
        if ($request->has('ar_ig') && $request->ar_ig != '') {
            $query->where('ar', '<=', $request->ar_ig);
        }
        // Km óra szűrés
        if ($request->has('km_ora_tol') && $request->km_ora_tol != '') {
            $query->where('km_ora', '>=', $request->km_ora_tol);
        }
        if ($request->has('km_ora_ig') && $request->km_ora_ig != '') {
            $query->where('km_ora', '<=', $request->km_ora_ig);
        }
        // Teljesítmény szűrés
        if ($request->has('teljesitmeny_tol') && $request->teljesitmeny_tol != '') {
            $query->where('teljesitmeny', '>=', $request->teljesitmeny_tol);
        }
        if ($request->has('teljesitmeny_ig') && $request->teljesitmeny_ig != '') {
            $query->where('teljesitmeny', '<=', $request->teljesitmeny_ig);
        }
        // Váltó szűrés
        if ($request->has('valto') && $request->valto != '') {
            $query->where('valto', $request->valto);
        }
        // Szín szűrés
        if ($request->has('szin') && $request->szin != '') {
            $query->where('szin', $request->szin);
        }
        // Karosszéria szűrés
        if ($request->has('karosszeria') && $request->karosszeria != '') {
            $query->where('karosszeria', $request->karosszeria);
        }
        // Üzemanyag szűrés
        if ($request->has('uzemanyag') && $request->uzemanyag != '') {
            $query->where('uzemanyag', $request->uzemanyag);
        }

    $cars = $query->orderBy('created_at', 'desc')->paginate(9);

    return view('cars.index', [
        'cars' => $cars,
        'brands' => $brands
    ]);
    }

   public function create()
{
    // Aktív márkák lekérése
    $brands = Brand::where('active', true)->orderBy('name')->get();
    $uzemanyagTipusok = ['benzin', 'gázolaj', 'hibrid', 'elektromos', 'gázüzemű'];

    return view('cars.create', [
        'brands' => $brands,
        'uzemanyagTipusok' => $uzemanyagTipusok
    ]);
}
    public function store(Request $request)
    {
        // Validáció
        $validated = $request->validate([
            'marka' => 'required',
            'modell' => 'required',
            'evjarat' => 'required|integer|min:1900|max:' . date('Y'),
            'ar' => 'required|integer|min:100000',
            'km_ora' => 'required|integer|min:0',
            'teljesitmeny' => 'required|integer|min:1',
            'uzemanyag' => 'required',
            'valto' => 'required',
            'szin' => 'required',
            'karosszeria' => 'required',
            'leiras' => 'required|min:10',
            'images.*' => 'image|max:2048'
        ], [
            'marka.required' => 'A gyártó mező kötelező!',
            'modell.required' => 'A modell mező kötelező!',
            'evjarat.required' => 'Az évjárat mező kötelező!',
            'ar.required' => 'Az ár mező kötelező!',
            'ar.min' => 'Minimum 100 000 Ft!',
            'km_ora.required' => 'A kilométeróra állás kötelező!',
            'teljesitmeny.required' => 'A teljesítmény kötelező!',
            'uzemanyag.required' => 'Az üzemanyag típusa kötelező!',
            'valto.required' => 'A váltó típusa kötelező!',
            'szin.required' => 'A szín kötelező!',
            'karosszeria.required' => 'A karosszéria típusa kötelező!',
            'leiras.required' => 'A leírás kötelező!',
            'leiras.min' => 'A leírás minimum 10 karakter!',
            'images.*.image' => 'Csak képfájl tölthető fel!',
            'images.*.max' => 'A kép maximum 2MB lehet!'
        ]);

        // Create storage directory if it doesn't exist
        if (!Storage::exists('public/cars')) {
            Storage::makeDirectory('public/cars');
        }

        // Autó mentése
        $car = new Car();
        $car->user_id = Auth::id();
        $brand = Brand::findOrFail($request->marka);
$car->marka = $brand->name;
        $car->modell = $validated['modell'];
        $car->evjarat = $validated['evjarat'];
        $car->ar = $validated['ar'];
        $car->km_ora = $validated['km_ora'];
        $car->teljesitmeny = $validated['teljesitmeny'];
        $car->uzemanyag = $validated['uzemanyag'];
        $car->valto = $validated['valto'];
        $car->szin = $validated['szin'];
        $car->karosszeria = $validated['karosszeria'];
        $car->leiras = $validated['leiras'];

        // Extrák mentése
        if ($request->has('extrak')) {
            $car->extrak = implode(',', $request->extrak);
        }

        $car->save();


    // Képek mentése közvetlenül public/storage/cars-ba
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/cars'), $filename);

            $car->images()->create([
                'path' => $filename
            ]);

            if ($index === 0) {
                $car->kep = $filename;
                $car->save();
            }
        }
    }

    return redirect()
            ->route('cars.show', $car)
            ->with('success', 'Autóhirdetés sikeresen létrehozva!');
    }

    public function edit(Car $car)
    {
        // Ellenőrizzük, hogy a felhasználó sajátja-e a hirdetés
        if ($car->user_id !== auth()->id()) {
        return redirect()->route('cars.index')->with('error', 'Nem módosíthatod más hirdetését!');
    }

    $brands = Brand::where('active', true)->orderBy('name')->get();

    return view('cars.edit', [
        'car' => $car,
        'brands' => $brands
    ]);
}

    public function update(Request $request, Car $car)
    {
        // Ellenőrizzük, hogy a felhasználó sajátja-e a hirdetés
        if ($car->user_id !== auth()->id()) {
            return redirect()->route('cars.index')->with('error', 'Nem módosíthatod más hirdetését!');
        }

        // Validáció
        $validated = $request->validate([
            'marka' => 'required',
            'modell' => 'required',
            'evjarat' => 'required|integer|min:1900|max:' . date('Y'),
            'ar' => 'required|integer|min:100000',
            'km_ora' => 'required|integer|min:0',
            'teljesitmeny' => 'required|integer|min:1',
            'uzemanyag' => 'required',
            'valto' => 'required',
            'szin' => 'required',
            'karosszeria' => 'required',
            'leiras' => 'required|min:10',
            'images.*' => 'image|max:2048'
        ]);

        // Autó adatainak frissítése
        $car->update([
            'marka' => $validated['marka'],
            'modell' => $validated['modell'],
            'evjarat' => $validated['evjarat'],
            'ar' => $validated['ar'],
            'km_ora' => $validated['km_ora'],
            'teljesitmeny' => $validated['teljesitmeny'],
            'uzemanyag' => $validated['uzemanyag'],
            'valto' => $validated['valto'],
            'szin' => $validated['szin'],
            'karosszeria' => $validated['karosszeria'],
            'leiras' => $validated['leiras'],
            'extrak' => $request->has('extrak') ? implode(',', $request->extrak) : null
        ]);

        // Új képek mentése
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/cars'), $filename);

            $car->images()->create([
                'path' => $filename
            ]);
        }
    }

        return redirect()
            ->route('cars.show', $car)
            ->with('success', 'Hirdetés sikeresen módosítva!');
    }

    // Új metódus kép törléshez
    public function deleteImage($carId, $imageId)
    {
        $car = Car::findOrFail($carId);

        if ($car->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Nem törölheted más hirdetésének képeit!');
        }

        $image = $car->images()->findOrFail($imageId);
        $path = public_path('storage/cars/' . $image->path);
        if (file_exists($path)) {
        unlink($path);
        }
        $image->delete();

        return redirect()->back()->with('success', 'Kép sikeresen törölve!');
    }

    public function myCars()
{
    $cars = Car::where('user_id', Auth::id())
              ->orderBy('created_at', 'desc')
              ->paginate(9);

    return view('cars.my-cars', ['cars' => $cars]);
}

public function destroy(Car $car)
{
    // Csak a saját hirdetés törölhető, vagy admin
    if (auth()->id() !== $car->user_id && auth()->user()->role !== 'admin') {
        abort(403, 'Nincs jogosultságod a hirdetés törléséhez.');
    }

    // Ha van kép, törlés
    if ($car->kep && file_exists(public_path('storage/cars/' . $car->kep))) {
        unlink(public_path('storage/cars/' . $car->kep));
    }

    $car->delete();

    return redirect()->route('cars.index')->with('success', 'A hirdetés sikeresen törölve!');
}
public function userCars($userId)
{
    $user = User::findOrFail($userId);
    $cars = Car::where('user_id', $userId)
              ->orderBy('created_at', 'desc')
              ->paginate(9);

    return view('cars.user-cars', [
        'cars' => $cars,
        'user' => $user
    ]);
}

}

