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
        $settings = Settings::all();

        View::composer('*', function ($view) use ($settings) {
            $wtitle = $wdesc = $wlogo = $wfavicon = null;
            $feature = collect([
                [
                    'name' => 'Dashboard',
                    'url' => route('dashboard.index')
                ], [
                    'name' => 'Pages',
                    'url' => route('dashboard.page.index')
                ], [
                    'name' => 'Category',
                    'url' => route('dashboard.category.index')
                ], [
                    'name' => 'Keyword',
                    'url' => route('dashboard.keyword.index')
                ], [
                    'name' => 'Post',
                    'url' => route('dashboard.post.index')
                ], [
                    'name' => 'Event',
                    'url' => route('dashboard.event.index')
                ], [
                    'name' => 'Panti',
                    'url' => route('dashboard.panti.index')
                ], [
                    'name' => 'Liputan Panti',
                    'url' => route('dashboard.panti.liputan.index')
                ], [
                    'name' => 'Donation',
                    'url' => route('dashboard.donation.index')
                ], [
                    'name' => 'Location Setting - Provinsi',
                    'url' => route('dashboard.provinsi.index')
                ], [
                    'name' => 'Location Setting - Kabupaten',
                    'url' => route('dashboard.kabupaten.index')
                ], [
                    'name' => 'Location Setting - Kecamatan',
                    'url' => route('dashboard.kecamatan.index')
                ], [
                    'name' => 'Profile',
                    'url' => route('dashboard.profile.index')
                ], [
                    'name' => 'Setting',
                    'url' => route('dashboard.setting.index')
                ], [
                    'name' => 'Roles',
                    'url' => route('dashboard.roles-setting.index')
                ], [
                    'name' => 'Clear Cache',
                    'url' => route('dashboard.clear.cache')
                ], [
                    'name' => 'Clear Config Cache',
                    'url' => route('dashboard.clear.config')
                ], [
                    'name' => 'Clear View Cache',
                    'url' => route('dashboard.clear.view')
                ], [
                    'name' => 'Error Log',
                    'url' => route('log-viewer::dashboard')
                ]
            ]);

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
                'feature' => $feature
            ]);
        });
    }
}
