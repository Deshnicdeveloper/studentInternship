<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'academic_year' => 'required|string|max:20',
        ]);

        Setting::set('system_name', $request->system_name);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('academic_year', $request->academic_year);

        return back()->with('success', 'Settings updated successfully.');
    }
}
