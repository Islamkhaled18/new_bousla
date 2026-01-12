<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait ToggleStatusTrait
{
    public function toggleStatusModel(Model $model)
    {
        try {
            DB::beginTransaction();

            $model->update([
                'is_active' => !$model->is_active,
            ]);

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'تم تغيير الحالة بنجاح',
                'is_active' => $model->is_active,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تغيير الحالة'
            ], 500);
        }
    }
}
