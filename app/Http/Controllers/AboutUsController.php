<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AboutUsController extends Controller
{
    private const CACHE_KEY = 'about_us_list';
    private const CACHE_DURATION = 900;

    public function index()
    {
        $about_us = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return AboutUs::all();
        });
        
        return view('admin.about-us.index', compact('about_us'));
    } //end of index

    public function create()
    {
        return view('admin.about-us.create');
    } //end of create

    public function store(AboutusRequest $request)
    {
        DB::beginTransaction();
        try {
            Aboutus::create($request->validated());
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('about-us.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(Aboutus $about_u)
    {
        return view('admin.about-us.edit', compact('about_u'));
    } //end of edit

    public function update(AboutUsRequest $request, Aboutus $about_u)
    {
        DB::beginTransaction();
        try {
            $about_u->update($request->validated());
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('about-us.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(Aboutus $about_u)
    {
        DB::beginTransaction();
        try {
            $about_u->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('about-us.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy
}