<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings;

use Storage;
use Carbon\Carbon;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::all();
        return view('content.dashboard.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Settings::all();

        // Compare Added Setting with Avail Setting
        $setting_added = array();
        foreach($settings as $val){
            array_push($setting_added, $val->setting_key);
        }
        $avail_setting = array(
            'title',
            'description',
            'favicon',
            'logo'
        );

        if(count($avail_setting) > count(array_intersect($avail_setting, $setting_added))){
            return view('content.dashboard.settings.create');
        } else {
            // Redirect back because all setting are set
            return redirect()->route('dashboard.setting.index')->with([
                'action' => 'Informartion',
                'message' => 'No Need to Add New Setting. All Setting are Set',
                'status' => 'info'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $value_index = null;
        $value_rule = null;
        if($request->setting_key == 'title' || $request->setting_key == 'description'){
            $value_index = 'setting_value';
            $value_rule = ['required', 'string'];
        } else {
            $value_index = 'setting_value_file';
            $value_rule = ['required'];
        }
        $request->validate([
            'setting_name' => ['required', 'string'],
            'setting_description' => ['nullable', 'string', 'max:255'],
            $value_index => $value_rule
        ]);

        $settings = new Settings;
        $settings->setting_key = $request->setting_key;
        $settings->setting_name = $request->setting_name;
        $settings->setting_description = $request->setting_description;
        if($request->setting_key == 'title' || $request->setting_key == 'description'){
            $settings->setting_value = $request->setting_value;
        } else {
            $settings->setting_value = $this->imageUpload($request);
        }
        $settings->save();

        return redirect()->route('dashboard.setting.index')->with([
            'action' => 'Store',
            'message' => 'Website Setting successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Settings::findOrFail($id);
        $stitle = Settings::whereSettingKey('title')->first();
        $sdesc = Settings::whereSettingKey('description')->first();
        $sfavicon = Settings::whereSettingKey('favicon')->first();
        $slogo = Settings::whereSettingKey('logo')->first();
        return view('content.dashboard.settings.edit', compact('setting', 'stitle', 'sdesc', 'sfavicon', 'slogo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settings = Settings::findOrFail($id);

        $value_rule = null;
        if($request->setting_key == 'title' || $request->setting_key == 'description'){
            $value_rule = ['required', 'string'];
        } else {
            $value_rule = ['nullable'];
        }
        $request->validate([
            'setting_name' => ['required', 'string'],
            'setting_description' => ['nullable', 'string', 'max:255'],
            'setting_value' => $value_rule
        ]);

        $settings->setting_key = $request->setting_key;
        $settings->setting_name = $request->setting_name;
        $settings->setting_description = $request->setting_description;
        if($request->setting_key == 'title' || $request->setting_key == 'description'){
            $settings->setting_value = $request->setting_value;
        } else {
            if($request->hasFile('setting_value')){
                Storage::delete('settings'.'/'.$settings->setting_value); // Delete old file

                $settings->setting_value = $this->imageUpload($request);
            }
        }
        $settings->save();

        return redirect()->route('dashboard.setting.index')->with([
            'action' => 'Update',
            'message' => 'Website Setting successfully added'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }

    /**
     * Upload Files to App
     * 
     */
    private function imageUpload($request, $location = 'settings')
    {
        $uploadedFile = $request->has('setting_value') ? $request->file('setting_value') : $request->file('setting_value_file');        
        $filename = strtolower($request->setting_key).'-'.(Carbon::now()->timestamp+rand(1,1000));
        $path = $uploadedFile->storeAs($location, $filename.'.'.$uploadedFile->getClientOriginalExtension());
        
        return $filename.'.'.$uploadedFile->getClientOriginalExtension();
    }
}
