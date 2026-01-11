<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $collection         = Setting::get();
        $setting['setting'] = $collection->flatMap(function ($collection) {
            return [$collection->key => $collection->value];
        });
        return view('admin.settings.index', $setting);
    }

    public function update(Request $request)
    {
        $info = $request->except('_token', '_method');
        foreach ($info as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }
}
