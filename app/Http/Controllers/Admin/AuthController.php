<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Libraries\General;
use App\Models\Admin\AdminAuth;
use App\Models\UserAuth;
use App\Models\Admin\Admins;

class AuthController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

    function login(Request $request)
    {
    	if($request->isMethod('post'))
    	{
	    	if($request->has(['email', 'password']))
	    	{
	    		$validator = Validator::make(
		            $request->toArray(),
		            [
		                'email' => 'required|email',
		                'password' => 'required'
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	//Validate recaptcha and throw error.
		        	if(Settings::get('admin_recaptcha'))
		        	{
		        		if(!$request->get('g-recaptcha-response') || !General::validateReCaptcha( $request->get('g-recaptcha-response') ))
		        		{
		        			$request->session()->flash('error', 'Captcha does not match. Please try again.');
			        		return redirect()->back()->withInput();
		        		}
		        	}

		        	// dd($request->all());
			    	// Make user login
			    	$admin = AdminAuth::attemptLogin($request);
			        if ($admin) {
						
						if($admin->status == 0){
							$request->session()->flash('error', 'Your request has been blocked. Please disconnect from any proxy or cloaking service such as TOR.');
			        	return redirect()->back()->withInput();
						}elseif(Settings::get('admin_second_auth_factor'))
			        	{
			        		$otp = General::hash(8);
			        		$admin->token = General::hash();
			        		$admin->otp = $otp;
			        		if($admin->save())
			        		{
			        			$codes = [
			        				'{first_name}' => $admin->first_name,
			        				'{last_name}' => $admin->last_name,
			        				'{one_time_password}' => $otp
			        			];
			        			General::sendTemplateEmail($admin->email, 'admin-second-auth-otp', $codes);

			        			return redirect()->route('admin.secondAuth', [ 'token' => General::encrypt($admin->token) ]);
			        		}
			        		else
			        		{
			        			$request->session()->flash('error', 'Session could not be establised. Please try again.');
				        		return redirect()->back()->withInput();			
			        		}
			        	}
			        	else
			        	{
				        	$adminLogin = AdminAuth::makeLoginSession($request, $admin);

                    	    $user = UserAuth::attemptLogin($request);
							// dd($user);
                    	    $userLogin = UserAuth::makeLoginSession($request, $user);

                    	    if ($adminLogin || $userLogin) {
                    	        return redirect()->route('admin.dashboard');
                    	    } else {
                    	        $request->session()->flash('error', 'Session could not be established for admin or user. Please try again.');
                    	        return redirect()->back()->withInput();
                    	    }
                    	}
			        }
			        else
			        {
						
			        	$request->session()->flash('error', 'The credentials that you\'ve entered doesn\'t match any account');
			        	return redirect()->back()->withInput();
			        }
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
		    }
		    else
		    {
		    	$request->session()->flash('error', 'Invalid request.');
		        return redirect()->back()->withInput();
		    }
	    }

	    $data = [
	    	'recaptchaEnabled' => Settings::get('admin_recaptcha'),
	    	'secondAuthEnabled' => Settings::get('admin_second_auth_factor')
	    ];
    	return view("admin/auth/login", $data);
    }

    function secondAuth(Request $request, $token)
    {
    	$otp = $request->get('otp');
		$user = AdminAuth::getRow([
			'token LIKE ?' => [
				General::decrypt($token)
			],
			'status' => 1
		]);

		if(!$user)
		{
			return redirect()->route('admin.login');
		}

    	if($request->isMethod('post'))
    	{
	    	if($request->get('otp'))
	    	{
	    		
    			if($user->otp == $otp)
    			{
    				$user->otp = null;
    				$user->token = null;
    				if($user->save())
    				{
    					$user = AdminAuth::makeLoginSession($request, $user);
			        	if($user)
			        	{
			        		return redirect()->route('admin.dashboard');
			        	}
			        	else
			        	{
			        		$request->session()->flash('error', 'Session could not be establised. Please try again.');
			        		return redirect()->route('admin.login');
			        	}
    				}
    				else
    				{
    					$request->session()->flash('error', 'Something went wrong. Please try again.');
    					return redirect()->route('admin.login');
    				}
    			}
    			else
    			{
    				$request->session()->flash('error', 'The one time password is incorrect.');
		    		return redirect()->back()->withInput();
    			}
	    	}
	    	else
	    	{
	    		$request->session()->flash('error', 'Please enter your one time password.');
			    return redirect()->back()->withInput();
	    	}
	    }

    	return view("admin/auth/secondAuth", ['token' => $token]);
    }

    function forgotPassword(Request $request)
    {
    	if($request->isMethod('post'))
    	{
	    	if($request->get('email'))
	    	{
	    		$email = $request->get('email');
	    		$admin = Admins::getRow([
	    			'email LIKE ?' => [$email],
	    			'status' => 1
	    		]);

	    		if($admin)
	    		{
	    			$admin->token = General::hash();
	    			if($admin->save())
	    			{
	    				$codes = [
	        				'{first_name}' => $admin->first_name,
	        				'{last_name}' => $admin->last_name,
	        				'{email}' => $admin->email,
	        				'{recovery_link}' => url()->route('admin.recoverPassword', ['hash' => $admin->token])
	        			];

	        			General::sendTemplateEmail(
	        				$admin->email, 
	        				'admin-forgot-password',
	        				$codes
	        			);

	    				$request->session()->flash('success', 'We have sent you a recovery link on your email. Please check your email.');
	    				return redirect()->route('admin.forgotPassword');	
	    			}
	    			else
	    			{
	    				$request->session()->flash('error', 'Something went wrong. Please try again.');
	    				return redirect()->back()->withInput();		
	    			}
			    	
	    		}
	    		else
	    		{
	    			$request->session()->flash('error', 'Email is not registered with us.');
			    	return redirect()->back()->withInput();
	    		}
	    	}
	    	else
	    	{
	    		$request->session()->flash('error', 'Please enter your register email to recover password.');
			    return redirect()->back()->withInput();
	    	}
	    }

    	return view("admin/auth/forgotPassword");
    }

    function recoverPassword(Request $request, $hash)
    {
    	$admin = Admins::getRow([
    			'token like ?' => [$hash]
    		]);
    	if($admin)
    	{
	    	if($request->isMethod('post'))
	    	{
	    		$data = $request->toArray();

	            $validator = Validator::make(
		            $request->toArray(),
		            [
		                'new_password' => [
		                	'required',
						    'min:8'
		                ],
		                'confirm_password' => [
		                	'required',
						    'min:8'
		                ]
		            ]
		        );

		        if(!$validator->fails())
		        {
		        	unset($data['_token']);
	        		if($data['new_password'] && $data['confirm_password'] && $data['new_password'] == $data['confirm_password'])
	        		{
	        			$admin->password = $data['new_password'];
	        			if($admin->save())
	        			{
	        				$request->session()->flash('success', 'Password updated successfully. Login with new credentials to proceed.');
		    				return redirect()->route('admin.login');
	        			}
	        			else
	        			{
	        				$request->session()->flash('error', 'New password could be updated.');
		    				return redirect()->back()->withErrors($validator)->withInput();				
	        			}
	        		}
	        		else
	        		{
	        			$request->session()->flash('error', 'New password does not match.');
		    			return redirect()->back()->withErrors($validator)->withInput();		
	        		}
			    }
			    else
			    {
			    	$request->session()->flash('error', 'Please provide valid inputs.');
			    	return redirect()->back()->withErrors($validator)->withInput();
			    }
			}
			return view("admin/auth/recoverPassword");
		}
		else
		{
			abort(404);
		}
    }

    function logout(Request $request)
    {
    	AdminAuth::logout();
		UserAuth::logout();
    	
    	return redirect()->route('admin.login');	
    }
}
