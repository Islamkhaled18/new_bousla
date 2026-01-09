<?php

namespace App\Http\Controllers;

use App\Http\Requests\GovernorateRequest;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Traits\ToggleStatusTrait;

class GovernorateController extends Controller
{
    use ToggleStatusTrait;

    public function index()
    {

        $governorates = Governorate::paginate(10);
        return view('admin.governorates.index', compact('governorates'));
    } //end of index

    public function create()
    {

        return view('admin.governorates.create');
    } //end of create

    public function store(GovernorateRequest $request)
    {
        Governorate::create($request->validated());

        return redirect()->route('governorates.index')->with('success', 'تم الحفظ بنجاح');
    } //end of store

    public function edit(Governorate $governorate)
    {

        return view('admin.governorates.edit', compact('governorate'));
    } //end of edit

    public function update(GovernorateRequest $request, Governorate $governorate)
    {
        $governorate->update($request->validated());

        return redirect()->route('governorates.index')->with('success', 'تم التعديل بنجاح');
    } //end of update

    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        return redirect()->route('governorates.index')->with('success', 'تم الحذف بنجاح');
    } //end of destroy

    public function toggleStatus(Governorate $governorate)
    {
        return $this->toggleStatusModel($governorate);
    }
    //end of toggleStatus
}
