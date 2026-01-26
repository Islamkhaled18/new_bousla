<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getWatsappNumber()
    {
        $whatsappSetting = Setting::where('key', 'whatsapp')->first();

        if (!$whatsappSetting) {
            return response()->json([
                'success' => false,
                'message' => 'رقم الواتساب غير متوفر حالياً',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'whatsapp' => $whatsappSetting->value,
            ]
        ], 200);
    }
}
