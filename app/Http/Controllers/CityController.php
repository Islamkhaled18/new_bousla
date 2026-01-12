<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            City::create($request->validated());
            DB::commit();
            return redirect()->route('cities.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    }

    public function edit(City $city)
    {

        $governorates = Governorate::where('is_active', 1)->get();
        return view('admin.cities.edit', compact('city', 'governorates'));
    }

    public function update(CityRequest $request, City $city)
    {
        DB::beginTransaction();
        try {
            $city->update($request->validated());
            DB::commit();
            return redirect()->route('cities.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    }

    public function destroy(City $city)
    {
        DB::beginTransaction();
        try {
            $city->delete();
            DB::commit();
            return redirect()->route('cities.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    public function toggleStatus(City $city)
    {
        return $this->toggleStatusModel($city);
    }
    //end of toggleStatus

}
