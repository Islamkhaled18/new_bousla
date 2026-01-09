<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobTitleRequest;
use App\Models\JobTitle;
use App\Traits\ToggleStatusTrait;

class JobTitleController extends Controller
{
    use ToggleStatusTrait;

    public function index()
    {

        $job_titles = JobTitle::paginate(10);
        return view('admin.job_titles.index', compact('job_titles'));
    } //end of index

    public function create()
    {

        return view('admin.job_titles.create');
    } //end of create

    public function store(JobTitleRequest $request)
    {
        JobTitle::create($request->validated());

        return redirect()->route('job-titles.index')->with('success', 'تم الحفظ بنجاح');
    } //end of store

    public function edit(JobTitle $job_title)
    {

        return view('admin.job_titles.edit', compact('job_title'));
    } //end of edit

    public function update(JobTitleRequest $request, JobTitle $job_title)
    {
        $job_title->update($request->validated());

        return redirect()->route('job-titles.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(JobTitle $job_title)
    {
        $job_title->delete();
        return redirect()->route('job-titles.index');
    } //end of destroy

    public function toggleStatus(JobTitle $job_title)
    {
        return $this->toggleStatusModel($job_title);
    }
    //end of toggleStatus
}
