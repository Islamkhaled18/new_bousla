<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivacyPolicyRequest;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivacyPolicyController extends Controller
{
    public function index()
    {

        $privacy_policies = PrivacyPolicy::paginate(10);
        return view('admin.privacy-policies.index', compact('privacy_policies'));
    } //end of index

    public function create()
    {
        return view('admin.privacy-policies.create');
    } //end of create

    public function store(PrivacyPolicyRequest $request)
    {
        DB::beginTransaction();
        try {
            PrivacyPolicy::create($request->validated());
            DB::commit();
            return redirect()->route('privacy-policies.index')->with('success', 'تم الحفظ بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحفظ')->withInput();
        }
    } //end of store

    public function show(PrivacyPolicy $privacy_policy)
    {
        return view('admin.privacy-policies.show', compact('privacy_policy'));
    } //end of show
    

    public function edit(PrivacyPolicy $privacy_policy)
    {
        return view('admin.privacy-policies.edit', compact('privacy_policy'));
    } //end of edit

    public function update(PrivacyPolicyRequest $request, PrivacyPolicy $privacy_policy)
    {
        DB::beginTransaction();
        try {
            $privacy_policy->update($request->validated());
            DB::commit();
            return redirect()->route('privacy-policies.index')->with('success', 'تم التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء التعديل')->withInput();
        }
    } //end of update

    public function destroy(PrivacyPolicy $privacy_policy)
    {
        DB::beginTransaction();
        try {
            $privacy_policy->delete();
            DB::commit();
            return redirect()->route('privacy-policies.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy
}
