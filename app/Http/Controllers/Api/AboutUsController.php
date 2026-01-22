<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsResource;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
         $about_us = AboutUs::get();

        return response()->json([
            'success' => true,
            'data' => [
                'about_us' =>  AboutUsResource::collection($about_us),
            ]
        ], 200);
    }
}
