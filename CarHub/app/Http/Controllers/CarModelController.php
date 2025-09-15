<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;


class CarModelController extends Controller
{
    public function index($brandId)
    {
        $brand = Brand::with('models')->findOrFail($brandId);
        return view('models.index', ['brand' => $brand]);
    }

    public function store(Request $request, $brandId)
    {
        {
    if (!auth()->check() || auth()->user()->role !== 'admin') { abort(403, 'Nincs jogosultságod modell hozzáadásához.');
    }
        $request->validate([
            'name' => 'required|unique:car_models,name,NULL,id,brand_id,'.$brandId,
        ]);

        $model = new CarModel();
        $model->brand_id = $brandId;
        $model->name = $request->name;
        $model->save();

        return redirect()->back()->with('success', 'Modell sikeresen hozzáadva!');
        }
    }

    public function destroy($brandId, $modelId)
    {
         // Csak az admin törölheti a modellt
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Csak az admin törölhet modellt.');
    }
        $model = CarModel::findOrFail($modelId);
        $model->delete();
        return redirect()->back()->with('success', 'Modell sikeresen törölve!');
    }

    public function getModelsByBrand($brandId)
    {
        try {
            $models = CarModel::where('brand_id', $brandId)
                            ->where('active', true)
                            ->orderBy('name')
                            ->get();

            return response()->json($models);
        } catch (\Exception $e) {
            \Log::error('Error fetching models: ' . $e->getMessage());
            return response()->json(['error' => 'Hiba történt a modellek betöltésekor'], 500);
        }
    }
}
