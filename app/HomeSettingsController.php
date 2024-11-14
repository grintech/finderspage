<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Admins;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class HomeSettingsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
        die;
        if($request->isMethod('post'))
        {
            $data = $request->toArray();
            unset($data['_token']);
            pr($data); die;
            foreach ($data as $key => $value) {
                if($key == 'head_scripts')
                {
                    Settings::put('head_scripts', $value);
                }
                elseif($key == 'brands_logos')
                {
                    $logos = HomeSettings::get('brands_logos');
                    $logos = $logos ? json_decode($logos, true) : [];
                    $value = $value ? json_decode($value, true) : [];
                    $logos = array_merge($value, $logos);
                    HomeSettings::put('brands_logos', json_encode($logos));
                }
                else 
                {
                    $value = $value && is_array($value) ? json_encode($value, true) : $value;
                    HomeSettings::put(trim($key), $value);
                }
            }

            $request->session()->flash('success', 'Home page updated.');
            return redirect()->route('admin.homeSettings');
        }
    	return view("admin/settings/homeSetting");
    }

    function terms(Request $request)
    {        
        if($request->isMethod('post'))
        {
            $data = $request->toArray();
            unset($data['_token']);
            // pr($data); die;
            foreach ($data as $key => $value) {
                HomeSettings::put(trim($key), $value);
            }

            $request->session()->flash('success', 'Terms and conditions page saved.');
            return redirect()->route('admin.homeSettings.terms');
        }
        return view("admin/settings/termsPage");
    }

    function privacyPolicy(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->toArray();
            unset($data['_token']);
            // pr($data); die;
            foreach ($data as $key => $value) {
                HomeSettings::put(trim($key), $value);
            }

            $request->session()->flash('success', 'Terms and conditions page saved.');
            return redirect()->route('admin.homeSettings.privacyPolicy');
        }
        return view("admin/settings/privacyPage");
    }
}
