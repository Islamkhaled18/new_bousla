<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Cache::remember('active_ads', 600, function () {
            return Ad::where('is_active', 1)
                ->inRandomOrder() 
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'ads' =>  AdResource::collection($ads),
            ]
        ], 200);
    }
}
