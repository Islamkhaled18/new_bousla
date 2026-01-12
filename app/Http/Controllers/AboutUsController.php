<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function index()
    {

        $about_us = AboutUs::paginate(10);
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
            DB::commit();
            return redirect()->route('about-us.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy
}
