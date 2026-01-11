<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermConditionRequest;
use App\Models\TermCondition;
use Illuminate\Http\Request;

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
        TermCondition::create($request->validated());
        return redirect()->route('terms.index')->with('success', 'تم الحفظ بنجاح');
    } //end of store

    public function edit(TermCondition $term)
    {
        return view('admin.terms.edit', compact('term'));
    } //end of edit

    public function update(TermConditionRequest $request, TermCondition $term)
    {
        $term->update($request->validated());
        return redirect()->route('terms.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(TermCondition $term)
    {
        $term->delete();
        return redirect()->route('terms.index')->with('success', 'تم الحذف بنجاح');
    } //end of destroy
}
