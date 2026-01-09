<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ToggleStatusTrait
{
    public function toggleStatusModel(Model $model)
    {
        $model->update([
            'is_active' => ! $model->is_active,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'تم تغيير الحالة بنجاح',
            'is_active' => $model->is_active,
        ]);
    }
}
