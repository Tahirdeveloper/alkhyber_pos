<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.edit');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'logo'); 

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('images', 'public'); 
        $data['logo'] = $logoPath; 
    }

    foreach ($data as $key => $value) {
        $setting = Setting::firstOrCreate(['key' => $key]);
        $setting->value = $value;
        $setting->save();
    }

    return redirect()->route('settings.index');
    }
}
