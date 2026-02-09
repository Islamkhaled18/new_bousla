<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\Governorate;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    use ToggleStatusTrait;
    
    private const CACHE_KEY = 'cities_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $cities = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return City::with('governorate')->get();
        });
        
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
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
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
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('cities.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    }

    public function destroy(City $city)
    {
        if ($city->areas()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف المدينة لوجود مناطق تابعة لها');
        }
        
        DB::beginTransaction();
        try {
            $city->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('cities.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    }

    public function toggleStatus(City $city)
    {
        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($city);
    }
    //end of toggleStatus
}