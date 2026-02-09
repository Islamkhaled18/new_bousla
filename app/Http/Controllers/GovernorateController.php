<?php

namespace App\Http\Controllers;

use App\Http\Requests\GovernorateRequest;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class GovernorateController extends Controller
{
    use ToggleStatusTrait;
    
    private const CACHE_KEY = 'governorates_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $governorates = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return Governorate::all();
        });
        
        return view('admin.governorates.index', compact('governorates'));
    } //end of index

    public function create()
    {

        return view('admin.governorates.create');
    } //end of create

    public function store(GovernorateRequest $request)
    {
        DB::beginTransaction();
        try {
            Governorate::create($request->validated());
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('governorates.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(Governorate $governorate)
    {
        return view('admin.governorates.edit', compact('governorate'));
    } //end of edit

    public function update(GovernorateRequest $request, Governorate $governorate)
    {
        DB::beginTransaction();
        try {
            $governorate->update($request->validated());
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('governorates.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(Governorate $governorate)
    {
        if ($governorate->cities()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف المحافظة لوجود مدن تابعة لها');
        }
        DB::beginTransaction();
        try {
            $governorate->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('governorates.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(Governorate $governorate)
    {
        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($governorate);
    }
    //end of toggleStatus
}
