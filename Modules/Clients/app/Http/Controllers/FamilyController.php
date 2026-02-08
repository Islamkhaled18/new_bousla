<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Clients\app\Http\Requests\FamilyRequest;
use Modules\Clients\app\Transformers\FamilyResource;

class FamilyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $families = $user->families()->get();

        return response()->json([
            'success' => true,
            'data' => [
               'families' => FamilyResource::collection($families),
            ]
        ]);
    }

    public function store(FamilyRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::user()->id;
            Family::create($data);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة فرد للعائة بنجاح',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء اضافة فرد للعائة',
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Family::where('id', $id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'تم حذف العضو بنجاح',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف العضو',
            ], 500);
        }
    }
}
