<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Models\Settings;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $wtitle = $wdesc = $wlogo = $wfavicon = null;

            $settings = Settings::all();
            foreach($settings as $setting){
                if($setting->setting_key == 'title'){
                    $wtitle = $setting->setting_value;
                }
                if($setting->setting_key == 'description'){
                    $wdesc = $setting->setting_value;
                }
                if($setting->setting_key == 'logo'){
                    $wlogo = $setting->setting_value;
                }
                if($setting->setting_key == 'favicon'){
                    $wfavicon = $setting->setting_value;
                }
            }

            $view->with([
                'wtitle' => $wtitle,
                'wdesc' => $wdesc,
                'wlogo' => $wlogo,
                'wfavicon' => $wfavicon,
            ]);
        });
    }
}
