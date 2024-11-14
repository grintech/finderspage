<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Libraries\General;
use App\Models\Admin\Settings;
use App\Models\Admin\AdminAuth;
use App\Models\Admin\Permissions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Libraries\FileSystem;

class SettingsController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function index(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();

    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'company_name' => 'required',
	                'company_address' => 'required',
	                'admin_second_auth_factor' => 'required',
	                'currency_code' => 'required',
	                'currency_symbol' => 'required',
	                'admin_notification_email' => [
	                	'required',
	                	'email'
	                ]
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	$logo = null;
	        	if(isset($data['logo']) && $data['logo']) 
	        	{
	        		$logo = $data['logo'];
	        	}
	        	
	        	$favicon = null;
	        	if(isset($data['favicon']) && $data['favicon']) 
	        	{
	        		$favicon = $data['favicon'];
	        	}


	        	// if(isset($data['ignore_keywords']) && $data['ignore_keywords']) 
	        	// {
	        	// 	$favicon = $data['favicon'];
	        	// }

	        	unset($data['logo']);
	        	unset($data['favicon']);
	        	unset($data['_token']);

	        	foreach ($data as $key => $value) {
	        		Settings::put($key, $value);
	        	}

	        	if($logo)
	        	{
	        		Settings::put('logo', $logo);
	        	}

	        	if($favicon)
	        	{
	        		Settings::put('favicon', $favicon);
	        	}
	        	
        		$request->session()->flash('success', 'Settings updated successfully.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			}
		}

		return view("admin/settings/index", []);
	}

	function recaptcha(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'admin_recaptcha' => 'required',
	                'recaptcha_key' => 'required',
	                'recaptcha_secret' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	foreach ($data as $key => $value) {
	        		Settings::put($key, $value);
	        	}
	
        		$request->session()->flash('success', 'Recaptcha settings updated.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}

	function email(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'email_method' => 'required',
	                'from_email' => 'required',
	                'smtp_host' => 'required',
	                'smtp_encryption' => 'required',
	                'smtp_port' => 'required',
	                'smtp_username' => 'required',
	                'smtp_email' => 'required',
	                'sendgrid_email' => 'required',
	                'sendgrid_api_key' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	
	        	$password = null;
	        	if(isset($data['smtp_password']) && $data['smtp_password'])
	        	{
	        		$password = $data['smtp_password'];
	        	}
	        	unset($data['smtp_password']);

	        	foreach($data as $key => $value) {
	        		Settings::put($key, $value);
	        	}

	        	if(isset($password) && $password)
	        	{
	        		Settings::put('smtp_password', $password);
	        	}
	
        		$request->session()->flash('success', 'Password updated successfully.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}

	function dateTimeFormats(Request $request)
	{
		if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		$validator = Validator::make(
	            $request->toArray(),
	            [
	                'date_format' => 'required',
	                'time_format' => 'required'
	            ]
	        );

	        if(!$validator->fails())
	        {
	        	unset($data['_token']);
	        	
	        	foreach ($data as $key => $value) {
	        		Settings::put($key, $value);
	        	}

	        	$request->session()->flash('success', 'Date and time format updated.');
        		return redirect()->route('admin.settings');
			}
			else
			{
				$request->session()->flash('error', 'Please provide valid inputs.');
			    return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		else
		{
			abort(404);
		}
	}
	
	function footerLinks(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
        	foreach($data as $key => $value) {
        		if(!in_array($key, ['footer_logo']))
        			Settings::put($key, $value);
        		elseif(in_array($key, ['footer_logo']) && $value)
        			Settings::put($key, $value);
        	}

    		$request->session()->flash('success', 'Footer settings updated.');
    		return redirect()->route('admin.settings.footerLinks');
		}
		

		return view("admin/settings/footerLinks", []);
	}

	function social(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{
    		$data = $request->toArray();
    		unset($data['_token']);
        	foreach ($data as $key => $value) {
        		Settings::put($key, $value);
        	}

    		$request->session()->flash('success', 'Social links updated successfully.');
    		return redirect()->route('admin.settings');
			
		}
		else
		{
			abort(404);
		}
	}

	function aboutus(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{

    		$data = $request->toArray();
    		
    		unset($data['_token']);

        
		if (isset($data['image'])) {
		    $images = $data['image'];
		        $name = time() . '_' . $images->getClientOriginalName();
		        $destinationPath = public_path('/images_entrtainment');
		        $images->move($destinationPath, $name);
		        $data['image'] = $name;
			}
              // dd($image);
        	foreach($data as $key => $value) {
        		if(!in_array($key, ['about_us_banner', 'about_us_image', 'aboutus_section2_icon1', 'aboutus_section2_icon2']))
        			Settings::put($key, $value);
        		elseif(in_array($key, ['about_us_banner', 'about_us_image', 'aboutus_section2_icon1', 'aboutus_section2_icon2']) && $value)
        			Settings::put($key, $value);
        	}

    		$request->session()->flash('success', 'About us page updated.');
    		return redirect()->route('admin.settings.aboutus');
		}
		

		return view("admin/settings/aboutus", []);
	}


	function about_brenda(Request $request)
    {
		if(!AdminAuth::isAdmin())
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.settings');
    	}

    	if($request->isMethod('post'))
    	{

    		$data = $request->toArray();
    		
    		unset($data['_token']);

        
		// if (isset($data['image_brenda'])) {
		//     $images = $data['image_brenda'];
		//         $name = time() . '_' . $images->getClientOriginalName();
		//         $destinationPath = public_path('/images_aboutBrenda');
		//         $images->move($destinationPath, $name);
		//         $data['image_brenda'] = $name;
		// 	}


           if (isset($data['image_brenda'])) {
		    $images = $data['image_brenda'];
                $imageNames = [];

                foreach ($images as $image) {
                    $name = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('/images_blog_img');
                    $image->move($destinationPath, $name);
                    $imageNames[] = $name;
                }

                $Branda_image = implode(',',$imageNames);
                $data['image_brenda'] = $Branda_image;
            }
              // dd($image);
        	foreach($data as $key => $value) {
        		if(!in_array($key, ['about_us_banner', 'about_us_image', 'aboutus_section2_icon1', 'aboutus_section2_icon2']))
        			Settings::put($key, $value);
        		elseif(in_array($key, ['about_us_banner', 'about_us_image', 'aboutus_section2_icon1', 'aboutus_section2_icon2']) && $value)
        			Settings::put($key, $value);
        	}

    		$request->session()->flash('success', 'About us page updated.');
    		return redirect()->route('admin.settings.about.brenda');
		}
		

		return view("admin/settings/about-brenda", []);
	}
}
