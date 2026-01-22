<?php

namespace Modules\Clients\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Clients\app\Transformers\JobTitleResource;

class JobTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $job_titles = Cache::remember('active_job_titles', 600, function () {
            return JobTitle::where('is_active', 1)
                ->inRandomOrder()
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'job_titles' =>  JobTitleResource::collection($job_titles),
            ]
        ], 200);
    }
}
