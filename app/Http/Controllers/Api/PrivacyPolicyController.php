<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrivacyPolicyResource;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PrivacyPolicyController extends Controller
{
     public function index()
    {

         $privacy_policies = Cache::remember('active_privacy_policies', 600, function () {
            return PrivacyPolicy::get();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'privacy_policies' =>  PrivacyPolicyResource::collection($privacy_policies),
            ]
        ], 200);
    }
}
