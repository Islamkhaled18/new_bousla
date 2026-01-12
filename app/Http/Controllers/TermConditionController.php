<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermConditionRequest;
use App\Models\TermCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermConditionController extends Controller
{
    public function index()
    {
        $terms = TermCondition::paginate(10);
        return view('admin.terms.index', compact('terms'));
    } //end of index

    public function create()
    {
        return view('admin.terms.create');
    } //end of create

    public function store(TermConditionRequest $request)
    {
        DB::beginTransaction();
        try {
            TermCondition::create($request->validated());
            DB::commit();
            return redirect()->route('terms.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function edit(TermCondition $term)
    {
        return view('admin.terms.edit', compact('term'));
    } //end of edit

    public function update(TermConditionRequest $request, TermCondition $term)
    {
        DB::beginTransaction();
        try {
            $term->update($request->validated());
            DB::commit();
            return redirect()->route('terms.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(TermCondition $term)
    {
        DB::beginTransaction();
        try {
            $term->delete();
            DB::commit();
            return redirect()->route('terms.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy
}
