<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Traits\ToggleStatusTrait;

class CityController extends Controller
{
    use ToggleStatusTrait;

    public function index()
    {
        $cities = City::with('governorate')->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {

        $governorates = Governorate::where('is_active', 1)->get();
        return view('admin.cities.create', compact('governorates'));
    }

    public function store(CityRequest $request)
    {
        City::create($request->validated());
        return redirect()->route('cities.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function edit(City $city)
    {

        $governorates = Governorate::where('is_active', 1)->get();
        return view('admin.cities.edit', compact('city', 'governorates'));
    }

    public function update(CityRequest $request, City $city)
    {
        $city->update($request->validated());
        return redirect()->route('cities.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', 'تم الحذف بنجاح');
    }

    public function toggleStatus(City $city)
    {
        return $this->toggleStatusModel($city);
    }
    //end of toggleStatus

}
