<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrivacyPolicyRequest;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PrivacyPolicyController extends Controller
{
    private const CACHE_KEY = 'privacy_policies_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        $privacy_policies = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return PrivacyPolicy::all();
        });
        
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
            
            // Clear cache after adding
            Cache::forget(self::CACHE_KEY);
            
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
            
            // Clear cache after updating
            Cache::forget(self::CACHE_KEY);
            
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
            
            // Clear cache after deleting
            Cache::forget(self::CACHE_KEY);
            
            DB::commit();
            return redirect()->route('privacy-policies.index')->with('success', 'تم الحذف بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء الحذف');
        }
    } //end of destroy
}