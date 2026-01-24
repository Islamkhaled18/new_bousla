<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    public function index()
    {

         $faqs = Cache::remember('active_faqs', 600, function () {
            return Faq::where('is_active', 1)
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'faqs' =>  FaqResource::collection($faqs),
            ]
        ], 200);
    }
}
