<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsRequest;
use App\Models\AboutUs;

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
        Aboutus::create($request->validated());
        return redirect()->route('about-us.index')->with('success', 'تم الحفظ بنجاح');
    } //end of store

    public function edit(Aboutus $about_u)
    {

        return view('admin.about-us.edit', compact('about_u'));
    } //end of edit

    public function update(AboutUsRequest $request, Aboutus $about_u)
    {
        $about_u->update($request->validated());
        return redirect()->route('about-us.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(Aboutus $about_u)
    {

        $about_u->delete();

        return redirect()->route('about-us.index')->with('success', 'تم الحذف بنجاح');
    } //end of destroy
}
