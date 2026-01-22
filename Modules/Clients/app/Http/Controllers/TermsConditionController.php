<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TermCondition;
use Illuminate\Http\Request;
use Modules\Clients\app\Transformers\TermConditionResource;

class TermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $term = TermCondition::where('is_active', 1)
            ->where('role', 'patient')
            ->first();

          return response()->json([
                'success' => true,
                'data' => [
                    'term' => new TermConditionResource($term),
                ]
            ], 200);
    }
}