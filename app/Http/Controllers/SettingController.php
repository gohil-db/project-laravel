<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $setting = Setting::first();
        return view('content.admin.admin-website-settings',compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //  dd($request->all());
        //  dd($setting->all());

         $request->validate([
            'site_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $setting = Setting::first() ?? new Setting();

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logo'), $filename);
            $setting->logo = 'uploads/logo/' . $filename;
        }
 
        $setting->site_name = $request->site_name ?? $setting->site_name;
        $setting->address = $request->address ?? $setting->address;
        $setting->email = $request->email ?? $setting->email;
        $setting->number = $request->number ?? $setting->number;
        $setting->save();

        // Refresh global cache
        cache()->forget('global_setting');

        return redirect()->back()->with('success', 'Settings updated successfully.');       
    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
