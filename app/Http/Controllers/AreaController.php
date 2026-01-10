<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use App\Traits\ToggleStatusTrait;


class AreaController extends Controller
{
    use ToggleStatusTrait;

    public function index()
    {
        $areas = Area::with('city')->get();
        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {

        $cities = City::where('is_active', 1)->get();
        return view('admin.areas.create', compact('cities'));
    }

    public function store(AreaRequest $request)
    {
        Area::create($request->validated());
        return redirect()->route('areas.index')->with('success', 'تم الحفظ بنجاح');
    }

    public function edit(Area $area)
    {

        $cities = City::where('is_active', 1)->get();
        return view('admin.areas.edit', compact('area', 'cities'));
    }

    public function update(AreaRequest $request, Area $area)
    {
        $area->update($request->validated());
        return redirect()->route('areas.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Area $area)
    {

        $area->delete();
        return redirect()->route('areas.index')->with('success', 'تم الحذف بنجاح');
    }

    public function toggleStatus(Area $area)
    {
        return $this->toggleStatusModel($area);
    }
}
