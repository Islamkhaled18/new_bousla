<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdController extends Controller
{
    private const CACHE_KEY = 'ads_list';
    private const CACHE_DURATION = 900; // 15 minutes

    public function index()
    {
        // $ads = Cache::remember('ads_list', 600, function () {
        //     return Ad::where('is_active', 1)
        //         ->inRandomOrder()
        //         ->get();
        // });


        $ads = Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
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
