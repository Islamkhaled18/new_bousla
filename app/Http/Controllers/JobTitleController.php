<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleRequest;
use App\Models\JobTitle;
use App\Traits\ToggleStatusTrait;
use Illuminate\Support\Facades\DB;

class JobTitleController extends Controller
{
    use ToggleStatusTrait;

    public function index()
    {

        $job_titles = JobTitle::paginate(50);
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
            DB::commit();
            return redirect()->route('job-titles.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(JobTitle $job_title)
    {
        DB::beginTransaction();
        try {
            // if ($job_title->users()->exists()) {
            //     return back()->with('error', 'لا يمكن حذف الوظيفة لأنها مرتبطة ببيانات أخرى');
            // }

            $job_title->delete();
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

        return $this->toggleStatusModel($job_title);
    }
    //end of toggleStatus
}
