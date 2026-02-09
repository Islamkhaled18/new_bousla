<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Models\Area;
use App\Models\City;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AreaController extends Controller
{
    use ToggleStatusTrait;
    
    private const CACHE_KEY = 'areas_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $areas = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return Area::with('city')->get();
        });
        
        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        $cities = City::where('is_active', 1)->get();
        return view('admin.areas.create', compact('cities'));
    }

    public function store(AreaRequest $request)
    {
        DB::beginTransaction();
        try {
            Area::create($request->validated());
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('areas.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    }

    public function edit(Area $area)
    {
        $cities = City::where('is_active', 1)->get();
        return view('admin.areas.edit', compact('area', 'cities'));
    }

    public function update(AreaRequest $request, Area $area)
    {
        DB::beginTransaction();
        try {
            $area->update($request->validated());
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('areas.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    }

    public function destroy(Area $area)
    {
        DB::beginTransaction();
        try {
            $area->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('areas.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    public function toggleStatus(Area $area)
    {
        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($area);
    }
}