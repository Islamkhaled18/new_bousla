<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermConditionRequest;
use App\Models\TermCondition;
use App\Models\TermsAcceptance;
use App\Models\User;
use App\Traits\ToggleStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermConditionController extends Controller
{
    use ToggleStatusTrait;

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

            if ($term->role == 'client') {
                User::where('type', 'client')->update(['is_accept_terms' => 0]);
                $this->logoutUsersByType('client');
            } elseif ($term->role == 'doctor') {
                User::where('type', 'doctor')->update(['is_accept_terms' => 0]);
                $this->logoutUsersByType('doctor');
            }

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

    public function toggleStatus(TermCondition $term)
    {
        return $this->toggleStatusModel($term);
    } //end of toggleStatus

    public function termAcceptances()
    {
        $acceptances = TermsAcceptance::with(['user:id,first_name,last_name', 'termCondition:id,name,version'])
            ->paginate(10);

        return view('admin.terms.acceptances', compact('acceptances'));
    }

    /**
     * Logout all users of specific type (Sanctum)
     */
    private function logoutUsersByType($type)
    {
        $userIds = User::where('type', $type)->pluck('id');

        // Delete all Sanctum tokens for these users
        DB::table('personal_access_tokens')
            ->whereIn('tokenable_id', $userIds)
            ->where('tokenable_type', User::class)
            ->delete();

        // Delete web sessions for these users
        DB::table('sessions')
            ->whereIn('user_id', $userIds)
            ->delete();
    }
}
