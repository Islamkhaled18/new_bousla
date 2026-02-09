<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    use ToggleStatusTrait;
    
    private const CACHE_KEY = 'faqs_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $faqs = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return Faq::all();
        });
        
        return view('admin.faqs.index', compact('faqs'));
    } //end of index

    public function create()
    {
        return view('admin.faqs.create');
    } //end of create

    public function store(FaqRequest $request)
    {
        DB::beginTransaction();
        try {
            Faq::create($request->validated());
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('faqs.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    } //end of show

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    } //end of edit

    public function update(FaqRequest $request, Faq $faq)
    {
        DB::beginTransaction();
        try {
            $faq->update($request->validated());
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('faqs.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(Faq $faq)
    {
        DB::beginTransaction();
        try {
            $faq->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('faqs.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(Faq $faq)
    {
        if (!request()->ajax()) {
            abort(403);
        }

        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($faq);
    }
    //end of toggleStatus
}