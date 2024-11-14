<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Models\Admin\Permissions;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\AboutSettings;
use App\Models\Admin\Admins;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Libraries\FileSystem;
use App\Http\Controllers\Admin\AppController;

class AboutSettingsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
        // die('dd');
        if($request->isMethod('post'))
        {
            $data = $request->toArray();
            unset($data['_token']);
            foreach ($data as $key => $value) {
                $value = $value && is_array($value) ? json_encode($value, true) : $value;
                if($key == 'head_scripts')
                {
                    Settings::put('head_scripts', $value);
                }
                elseif($key == 'brands_logos')
                {
                    $logos = AboutSettings::get('brands_logos');
                    $logos = $logos ? json_decode($logos, true) : [];
                    $value = $value ? json_decode($value, true) : [];
                    $logos = array_merge($value, $logos);
                    AboutSettings::put('brands_logos', json_encode($logos));
                }
                else 
                {
                    AboutSettings::put(trim($key), $value);
                }
            }

            $request->session()->flash('success', 'About page updated.');
            return redirect()->route('admin.aboutSettings');
        }
    	return view("admin/settings/aboutus");
    }
}
