<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleRequest;
use App\Models\JobTitle;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class JobTitleController extends Controller
{
    use ToggleStatusTrait;
    
    private const CACHE_KEY = 'job_titles_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $job_titles = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return JobTitle::get();
        });
        
        return view('admin.job_titles.index', compact('job_titles'));
    } //end of index

    public function create()
    {
        return view('admin.job_titles.create');
    } //end of create

    public function store(JobTitleRequest $request)
    {
        DB::beginTransaction();
        try {
            JobTitle::create($request->validated());
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('job-titles.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(JobTitle $job_title)
    {
        return view('admin.job_titles.edit', compact('job_title'));
    } //end of edit

    public function update(JobTitleRequest $request, JobTitle $job_title)
    {
        DB::beginTransaction();
        try {
            $job_title->update($request->validated());
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('job-titles.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(JobTitle $job_title)
    {
        if ($job_title->users()->exists()) {
             return redirect()->back()->with('error', 'لا يمكن حذف الوظيفة لأنها مرتبطة ببيانات أخرى');
        }
        
        DB::beginTransaction();
        try {
            $job_title->delete();
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('job-titles.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy

    public function toggleStatus(JobTitle $job_title)
    {
        if (!request()->ajax()) {
            abort(403);
        }

        // Clear cache when status is toggled
        Cache::forget(self::CACHE_KEY);
        
        return $this->toggleStatusModel($job_title);
    }
    //end of toggleStatus
}