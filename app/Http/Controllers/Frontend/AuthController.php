<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\RateLimiter;
use App\Rules\DnsValidEmail;
use App\Models\Admin\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Settings;
use App\Libraries\General;
use App\Models\UserAuth;
use App\Models\BlockUser;
use App\Events\UserBlocked;
use App\Events\UserUnblocked;
use App\Models\Admin\Users;
use App\Models\Admin\WebSettings;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
// use App\Models\User; 
use DB;
use Auth;

class AuthController extends AppController
{
	function __construct()
	{
		parent::__construct();
	}

	function signup(Request $request)
	{

		if ($request->isMethod('post')) {
			
			$data = $request->toArray();
			unset($data['_token']);
			unset($data['confirm_password']);
			unset($data['accept']);
			unset($data['privacyPolicy']);
			unset($data['termCondition']);

			$validator = Validator::make(
			    $request->toArray(),
			    [
			        'first_name' => 'required',
			        'in_site_register' => 'required',
			        // 'g-recaptcha-response' => 'required|captcha',
			        'username' => [
			            'required',
			            Rule::unique('users'), // Ignore the current user's ID
			        ],
			        // 'dob' => [
			        //     'required',
			        //     'date',
			        //     'before_or_equal:' . now()->subYears(17)->format('Y-m-d'),
			        // ],
			        'email' => [
			            'required',
			            'email',
			            Rule::unique('users'),
			            new DnsValidEmail 
			        ],
			        'phonenumber' => [
			            // 'required',
			            // Rule::unique('users'),
			        ],
			        'password' => 'required'

			    ],
			    [
			        'email.unique' => 'Email already registered with us.',
			        'phonenumber.unique' => 'Phone number already registered with us.',

			    ]
			);

			// echo "<pre>";print_r($validator->fails());die();
			if (!$validator->fails()) {

				$enteredOTP = $request->input('otp');
				// dd($enteredOTP);
			    // Retrieve the saved OTP from the session
			    $savedOTP = Session::get('otp');

			    // echo "<pre>";print_r($enteredOTP);
			    // echo "<br>";
			    // echo "<pre>";print_r($savedOTP);
			    // die('dev');
			    // dd($savedOTP);
			    // Compare enteredOTP with savedOTP
			    if ($enteredOTP == $savedOTP) {
			        // OTP is correct, allow registration
			        // Proceed with registering the user
			    
				Users::where('email', 'LIKE', $data['email'])
					->where('completed', 1)
					->delete();

				$data['token'] = General::hash(64);
				$user = Users::create($data);
				if ($user) {
					if ($user->role == 'business') {
						$notice = [
							'from_id' => $user->id,
							'to_id' => 7,
							'type' => 'user',
							'message' => 'New account is created by this user ' . $user->username . '.',
						];
						Notification::create($notice);
						$link = url('/email-verification') . '/' . $data['token'];
						$codes = [
							'{name}' => $user->username,
							'{verification_link}' => General::urlToAnchor($link),
							'{business_name}' => @$user->business_name,
							'{business_email}' => @$user->business_email,
							'{business_phone}' => @$user->business_phone,
							'{business_website}' => @$user->business_website,
							'{business_address}' => @$user->business_address
						];
						// dd($codes);
						General::sendTemplateEmail(
							$user->email,
							'business-registration',
							$codes
						);

						General::sendTemplateEmail(
							'rajesh.rbgroup@gmail.com',
							'business-registration',
							$codes
						);
						$user->completed = 1;
						$user->save();

						return redirect()->route('auth.success');

						// return redirect()->route('auth.businessRegistration', [ 'token' => $user->token, 'id' => General::encrypt($user->id) ]);
					} else {
						$notice = [
							'from_id' => $user->id,
							'to_id' => 7,
							'message' => 'New user register.',
						];
						Notification::create($notice);
						$link = url('/email-verification') .'/' . $data['token'];
						$codes = [
							'{name}' => $user->username,
							'{verification_link}' => General::urlToAnchor($link)
						];

						General::sendTemplateEmail(
							$user->email,
							'client-registration',
							$codes
						);
						$user->completed = 1;
						$user->save();
						return redirect()->route('auth.success');
					}
				} else {
					$request->session()->flash('error', 'Account could not be create. Please try again.');
					return redirect()->back()->withErrors($validator)->withInput();
				}

			} else {
			        // OTP is incorrect, display an error message
				$request->session()->flash('error', 'OTP dose not match. Plese try again.');
				return redirect()->back()->withErrors($validator)->withInput();
			}
			}else {
				$request->session()->flash('error', 'Please provide valid inputs.');
				return redirect()->back()->withErrors($validator)->withInput();
			}


		}

		return view("frontend.auth.signup", []);
	}

	// function signup(Request $request)
	// {
	// 	if ($request->isMethod('post')) {
			
	// 		$data = $request->toArray();
	// 		unset($data['_token']);
	// 		unset($data['confirm_password']);
	// 		unset($data['accept']);
	// 		unset($data['privacyPolicy']);
	// 		unset($data['termCondition']);

	// 		$validator = Validator::make(
	// 			$request->toArray(),
	// 			[
	// 				'first_name' => 'required',
	// 				'in_site_register' => 'required',
	// 				'username' => [
	// 					'required',
	// 					Rule::unique('users'),
	// 				],
	// 				'email' => [
	// 					'required',
	// 					'email',
	// 					Rule::unique('users'),
	// 					new DnsValidEmail 
	// 				],
	// 				'phonenumber' => [
	// 					// 'required',
	// 					// Rule::unique('users'),
	// 				],
	// 				'password' => 'required'
	// 			],
	// 			[
	// 				'email.unique' => 'Email already registered with us.',
	// 				'phonenumber.unique' => 'Phone number already registered with us.',
	// 			]
	// 		);

	// 		if (!$validator->fails()) {
	// 			Users::where('email', 'LIKE', $data['email'])
	// 				->where('completed', 1)
	// 				->delete();

	// 			$data['token'] = General::hash(64);
	// 			$user = Users::create($data);
	// 			if ($user) {
	// 				if ($user->role == 'business') {
	// 					$notice = [
	// 						'from_id' => $user->id,
	// 						'to_id' => 7,
	// 						'type' => 'user',
	// 						'message' => 'New account is created by this user ' . $user->username . '.',
	// 					];
	// 					Notification::create($notice);
	// 					$link = url('/email-verification') . '/' . $data['token'];
	// 					$codes = [
	// 						'{name}' => $user->username,
	// 						'{verification_link}' => General::urlToAnchor($link),
	// 						'{business_name}' => @$user->business_name,
	// 						'{business_email}' => @$user->business_email,
	// 						'{business_phone}' => @$user->business_phone,
	// 						'{business_website}' => @$user->business_website,
	// 						'{business_address}' => @$user->business_address
	// 					];
	// 					General::sendTemplateEmail($user->email, 'business-registration', $codes);
	// 					General::sendTemplateEmail('rajesh.rbgroup@gmail.com', 'business-registration', $codes);

	// 					$user->completed = 1;
	// 					$user->verified_at = date('Y-m-d H:i:s');
	// 					$user->save();

	// 					return redirect()->route('auth.login');
	// 			// 		return redirect()->route('auth.success');
	// 				} else {
	// 					$notice = [
	// 						'from_id' => $user->id,
	// 						'to_id' => 7,
	// 						'message' => 'New user register.',
	// 					];
	// 					Notification::create($notice);
	// 					$link = url('/email-verification') . '/' . $data['token'];
	// 					$codes = [
	// 						'{name}' => $user->username,
	// 						'{verification_link}' => General::urlToAnchor($link)
	// 					];
	// 					General::sendTemplateEmail($user->email, 'client-registration', $codes);

	// 					$user->completed = 1;
	// 					$user->verified_at = date('Y-m-d H:i:s');
	// 					$user->save();
	// 			// 		return redirect()->route('auth.success');
	// 					return redirect()->route('auth.login');
	// 				}
	// 			} else {
	// 				$request->session()->flash('error', 'Account could not be created. Please try again.');
	// 				return redirect()->back()->withErrors($validator)->withInput();
	// 			}
	// 		} else {
	// 			$request->session()->flash('error', 'Please provide valid inputs.');
	// 			return redirect()->back()->withErrors($validator)->withInput();
	// 		}
	// 	}

	// 	return view("frontend.auth.signup", []);
	// }


	// function businessRegistration(Request $request, $token, $id)
	// {
	//     if(UserAuth::isLogin())
	//     {
	//         return redirect()->route('homepage.index');
	//     }

	//     $user = Users::where('token', $token)->where('id', General::decrypt($id))->first();

	//     if($request->isMethod('post'))
	//     {
	//         $data = $request->toArray();
	//         unset($data['_token']);
	//         $validator = Validator::make(
	//             $request->toArray(),
	//             [
	//                 'business_name' => 'required',
	//                 'business_email' => [
	//                     'email'
	//                 ]
	//             ]
	//         );
	//         if(!$validator->fails())
	//         {
	//         	$data['token'] = General::hash(64);
	//         	$data['completed'] = 1;
	//         	$data['verified_at'] = 1;
	//         	$data['status'] = 1;
	//             $user = Users::modify($user->id, $data);

	//             if($user)
	//             {
	//                 $link = url('/email-verification').'/'.$data['token'];
	//                 $codes = [
	//                     '{name}' => $user->first_name,
	//                     '{verification_link}' => General::urlToAnchor($link),
	//                     '{business_name}' => $user->business_name,
	//                     '{business_email}' => $user->business_email,
	//                     '{business_phone}' => $user->business_phone,
	//                     '{business_website}' => $user->business_website,
	//                     '{business_address}' => $user->business_address
	//                 ];

	//                 General::sendTemplateEmail(
	//                     $user->email, 
	//                     'business-registration',
	//                     $codes
	//                 );
	//                 return redirect()->route('auth.success');
	//             }
	//             else
	//             {
	//                 $request->session()->flash('error', 'Account could not be create. Please try again.');
	//                 return redirect()->back()->withErrors($validator)->withInput();
	//             }
	//         }
	//         else
	//         {
	//             $request->session()->flash('error', 'Please provide valid inputs.');
	//             return redirect()->back()->withErrors($validator)->withInput();
	//         }
	//     }

	//     return view("frontend.auth.businessRegistration", ['user' => $user]);
	// } 
	public function sessionDestory(){
		session()->flush();
	}
function login(Request $request)
	{
		$maxAttempts = 5;
	    $decayMinutes = 15;
	    $key = $request->ip();
	   $loginATP = session('loginATP', 0);

		if (UserAuth::isLogin()) {
			return redirect()->route('homepage.index');
		}

		
		
		
		

		if ($request->isMethod('post')) {

			// if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {

			// if ($loginATP > 5) {
			// 	Session::put('max_attempt_error_timestamp', now()->timestamp);
	        // // The user exceeded the attempt limit, redirect them to a password reset page
	        // return redirect()->route('auth.login')->with('maxattempt_error', 'Too many login attempts. Please reset your password or You can Try afyer 15 miniutes Thankyou ...');
	    	// 	}
			$data = $request->toArray();
			unset($data['_token']);

			$validator = Validator::make(
				$request->toArray(),
				[
					'email' => 'required',
					'password' => 'required'
				]
			);

			if (!$validator->fails()) {
				// Make user login
				$user = UserAuth::attemptLogin($request);
				// dd($user);
				// dd(Auth::user());


				if ($user && $user->status == 0) {
					$request->session()->flash('error', 'You are blocked by administrator. Please contact us.');
					return redirect()->route('auth.login');
				}
				elseif ($user && $user->deleted_at != null) {
					  $created_date = $user->deleted_at;
	                        $currentDateTime = date('Y-m-d H:i:s');

	                        // Convert the dates to timestamps
	                        $created_timestamp = strtotime($created_date);
	                        $current_timestamp = strtotime($currentDateTime);
	                        $seconds_diff = $current_timestamp - $created_timestamp;
	                        $days_diff = floor($seconds_diff / (60 * 60 * 24));

	                         if($days_diff <= '30.0'){
	                         	
	                         	$restore_user = DB::table('users')
					                    ->where('id', $user->id)
					                    ->limit(1)
					                    ->update([
					                        'deleted_at' => NULL,
					                    ]);
	                         	
	                         	if (!empty($restore_user) ) {
    								UserAuth::makeLoginSession($request, $user);
		                         	$request->session()->flash('success', 'You have successfully retrieved your account.');
									return redirect()->route('index_user');
	                         	}
	                         }else{
	                         	$request->session()->flash('error', 'Your account has been deleted. Please contact us.');
							return redirect()->route('auth.login');
	                         }
							
				}
				 elseif ($user && $user->verified_at == null) {
					if (isset($user->token) && $user->token) {
						$token = $user->token;
					} else {
						$user->token = General::hash(64);
						$user->save();

						$token = $user->token;
					}

					$link = url('/email-verification') . '/' . $token;

					if ($user && $user->role == 'business') {
						$codes = [
							'{name}' => $user->first_name,
							'{verification_link}' => General::urlToAnchor($link),
							'{business_name}' => $user->business_name,
							'{business_email}' => $user->business_email,
							'{business_phone}' => $user->business_phone,
							'{business_website}' => $user->business_website,
							'{business_address}' => $user->business_address
						];

						General::sendTemplateEmail(
							$user->email,
							'business-registration',
							$codes
						);
					} else {
						$codes = [
							'{name}' => $user->name,
							'{verification_link}' => General::urlToAnchor($link)
						];

						General::sendTemplateEmail(
							$user->email,
							'client-registration',
							$codes
						);
					}

					$request->session()->flash('error', 'Your account is not verified yet. Please check your inbox. We have sent a verification link to verify your email.');
					return redirect()->route('auth.login');
				} elseif ($user) {
							// $userID = implode(',', $userIdsArray);
							// Cookie::queue('loginUser', $userID, 7200);
							
							$cookieValue = Cookie::get('loginUser');
							$uId = explode(',', $cookieValue);
							
							// Check if the user ID already exists in the array
							$userIndex = array_search($user->id, $uId);
							if ($userIndex !== false) {
								// If the user ID exists, remove it
								unset($uId[$userIndex]);
							}
							
							// Add the new user ID to the end of the array
							$uId[] = $user->id;
							
							// Check if the number of values exceeds 5
							if (count($uId) > 5) {
								// Remove the first value
								array_shift($uId);
							}
							
							// Set the cookie with the updated values
							$newCookieValue = implode(',', $uId);
							Cookie::queue('loginUser', $newCookieValue, 60); // Set cookie for 60 minutes


					$login = UserAuth::makeLoginSession($request, $user);

					DB::table('users')
		                    ->where('id', $user->id)
		                    ->update([
		                        'active_status' => '1',
		                    ]);


					if ($login){
				Users::where('id',$user->id)->whereDate('feature_end_date','<', date('Y-m-d'))->update(['isfeatured_user' => 0]);
						
						//return redirect()->route('UserProfile', ['id' => General::encrypt($user->id)]);
						//return redirect()->route('businessRegistration', ['id' => General::encrypt($user->id)]);
						if ($user->role == 'business') {


							if ($user->first_time_login == 1) {
								// $userID = implode(',', $userIdsArray);
								// 	Cookie::queue('loginUser', $userID, 7200);

									$cookieValue = Cookie::get('loginUser');
									$uId = explode(',', $cookieValue);

									// Check if the user ID already exists in the array
									$userIndex = array_search($user->id, $uId);
									if ($userIndex !== false) {
										// If the user ID exists, remove it
										unset($uId[$userIndex]);
									}

									// Add the new user ID to the end of the array
									$uId[] = $user->id;

									// Check if the number of values exceeds 5
									if (count($uId) > 5) {
										// Remove the first value
										array_shift($uId);
									}

									// Set the cookie with the updated values
									$newCookieValue = implode(',', $uId);
									Cookie::queue('loginUser', $newCookieValue, 60); // Set cookie for 60 minutes
									
								 $codes = [
						                    '{first_name}' =>$user->first_name,
						                ];
						        General::sendTemplateEmail(
						                            $user->email,
						                            'login-security-email',
						                            $codes
						                        );

								$request->session()->flash('success', 'Login successfully.');
								return redirect()->route('index_user');
							} else {
								// $userID = implode(',', $userIdsArray);
								// Cookie::queue('loginUser', $userID, 7200);

								$cookieValue = Cookie::get('loginUser');
								$uId = explode(',', $cookieValue);

								// Check if the user ID already exists in the array
								$userIndex = array_search($user->id, $uId);
								if ($userIndex !== false) {
									// If the user ID exists, remove it
									unset($uId[$userIndex]);
								}

								// Add the new user ID to the end of the array
								$uId[] = $user->id;

								// Check if the number of values exceeds 5
								if (count($uId) > 5) {
									// Remove the first value
									array_shift($uId);
								}

								// Set the cookie with the updated values
								$newCookieValue = implode(',', $uId);
								Cookie::queue('loginUser', $newCookieValue, 60); // Set cookie for 60 minutes
								DB::table('users')
					                    ->where('id', $user->id)
					                    ->update([
					                        'first_time_login' => '1',
					                    ]);

								
								$allUsersEmail = Users::where('status', 1)
											->where('role', '!=', 'admin')
											->where('email', '!=', $user->email)
											->pluck('email');
								// dd($allUsersEmail);
								// implode(" ",$allUsersEmail);
								$codes = [
						                    '{first_name}' => $user->first_name,
											'{name}' => $user->username,
											'{profile_url}' => route('UserProfileFrontend', $user->slug),
						                ];
						        General::sendTemplateEmail(
						                    $user->email,
						                    'thankyou-mail',
						                    $codes
						                );

								// General::sendTemplateEmail(
								// 			$user->email,
								// 			'first-featured-or-bump',
								// 			$codes
								// 		);
								General::sendTemplateEmail(
											$allUsersEmail,
											'new-member-joining',
											$codes
										);

								// $request->session()->flash('success', 'Login successfully.');
								$request->session()->flash('login_popup', 'Your first paid listing is free! Simply create a post to see how it works. Thank you for choosing FindersPage.');
								// die('dev');
								return redirect()->route('index_user', ['token' => $user->token, 'id' => General::encrypt($user->id)]);
							}
						} else {
							 $codes = [
						                    '{first_name}' =>$user->first_name,
						                ];
						        General::sendTemplateEmail(
						                            $user->email,
						                            'login-security-email',
						                            $codes
						                        );

							$request->session()->flash('success', 'Login successfully.');
							return redirect()->route('index_user',['id' => General::encrypt($user->id)]);
						}
					} else {
						$request->session()->flash('error', 'Session could not be establised. Please try again.');
						return redirect()->route('auth.login');
					}
				} else {
					// Authentication failed, increment the attempt count
    				
    				$loginATP++;
    				session(['loginATP' => $loginATP]);
    				if ($loginATP > 5) {
						Session::put('max_attempt_error_timestamp', now()->timestamp);
			        // The user exceeded the attempt limit, redirect them to a password reset page
			        return redirect()->route('auth.login')->with('error', 'Too many login attempts. Please reset your password or you can try again after 15 minutes. Thank you!');
			    		}
    				
					$request->session()->flash('error', 'Your username or password is incorrect. Please try again.');
					return redirect()->route('auth.login');
				}
			} else {
				 // Authentication failed, increment the attempt count
    			RateLimiter::hit($key, $decayMinutes);
    			$loginATP++;
    			session(['loginATP' => $loginATP]);
    			if ($loginATP > 5) {
				Session::put('max_attempt_error_timestamp', now()->timestamp);
	        // The user exceeded the attempt limit, redirect them to a password reset page
	        return redirect()->route('auth.login')->with('error', 'Too many login attempts. Please reset your password or you can Try again after 1 miniute. Thankyou .');
	    		}
    			

				$request->session()->flash('error', 'Please provide valid inputs.');
				return redirect()->back()->withErrors($validator)->withInput();
			}
		}
		$cookieValue = Cookie::get('loginUser');
		//  DD($cookieValue);
		$uId = explode(',', $cookieValue);
		// dd($uId);
		$usersData = []; // Initialize an empty array to store the user data

		foreach ($uId as $new_Uid) {
		    $user = Users::select('first_name', 'email', 'id')
		                ->where('id', $new_Uid)
		                ->first(); // Use first() instead of get() to retrieve a single user

		    if ($user) {
		        $usersData[] = $user; // Add the user data to the array
		    }
		}

		return view("frontend/auth/login", ["accounts" => $usersData]);
		

		
	}


	function loginAPI(Request $request)
	{
		// dd('developer');
	   $validator = Validator::make(
				$request->toArray(),
				[
					'email' => 'required',
					'password' => 'required'
				]
			);


	   if (!$validator->fails()) {
				// Make user login
				$user = UserAuth::attemptLogin($request);

			if($user){
				return response()->json(['success'=>'Login successfully.','UserData'=>$user]);
			}else{
				return response()->json(['error'=>'Your username or password is incorrect. Please try again.','UserData'=>null]);
			}
		}else{

			return response()->json(['error'=> 'Please provide valid inputs.']);
		}
	}

	
	function signupAPI(Request $request)
	{
			$data = $request->all();
			// dd($data);
			$validator = Validator::make(
				$data,
				[
					'first_name' => 'required',
					'username' => 'required|unique:users',
					'email' => 'required|email|unique:users',
					'password' => 'required'
				]
			);
		
			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 422);
			}
		
			$data['password'] = Hash::make($data['password']);
			$data['token'] = General::hash(64); // Ensure you have the General::hash method available
		
			try {
				$user = Users::create($data);

				// dd($user);
				// Add additional logic here if needed, like sending notification and verification emails
		
				// You might need to adjust the response format according to your front-end requirements
				return response()->json(['success' => 'User successfully registered.', 'user' => $user], 201);
			} catch (\Exception $e) {
				return response()->json(['error' => 'User registration failed.'], 500);
			}

	}



public function switchAccount(Request $request){
	
	$id = $_POST['id'];
	$email = $_POST['email'];
	$user = UserAuth::attemptLoginId($id , $email);

	$login = UserAuth::makeLoginSession($request, $user);

	if($login){
		// dd($user);
		$request->session()->flash('success', 'Account switched successfully.');
		$response = [
                'status' => 'success',
                'message' => 'Account switch successfully.',
                'user_id' =>General::encrypt($user->id)
            ];
	}else{
		$request->session()->flash('error', 'Session could not be establised. Please try again.');
		 $response = [
                'status' => 'error',
                'message' => 'Session could not be established. Please try again.'
            ];
	}
	 return response()->json($response);
}

public function Remove_Switch_Account(Request $request){

	$id = $request->id;
	// dd($id);
	$existingUserIds = Cookie::get('loginUser');
	$userIdsArray = explode(',', $existingUserIds);
	$userIndex = array_search($id, $userIdsArray);
	if ($userIndex !== false) {
	    unset($userIdsArray[$userIndex]);
	    $userID = implode(',', $userIdsArray);
	Cookie::queue('loginUser', $userID, 7200);
		$request->session()->flash('success', 'Account removed successfully.');
	$response = [
                'status' => 'success',
                'message' => 'Account removed successfully.'
            ];
	return response()->json($response);
	} else {
	    $userIdsArray[] = $user->id;
	    $request->session()->flash('error', 'Account can not be removed. Please try again.');
	$response = [
                'status' => 'error',
                'message' => 'Account can not be removed. Please try again.'
            ];
	return response()->json($response);	
	}
		

	
}

function forgotPassword(Request $request)

    {

    	if($request->isMethod('post'))

    	{

	    	if($request->get('email'))

	    	{

	    		$email = $request->get('email');

	    		$user = Users::getRow([

	    			'email LIKE ?' => [$email],

	    			'status' => 1

	    		]);

	    		// dd($user);



	    		if($user)

	    		{

	    			$user->token = General::hash();

	    			if($user->save())

	    			{

	    				$codes = [

	        				'{first_name}' => $user->first_name,

	        				'{last_name}' => $user->last_name,

	        				'{email}' => $user->email,

	        				'{recovery_link}' => General::urlToAnchor(route('user.recoverPassword', ['hash' => $user->token]))
	        				// '{recovery_link}' => url()->route('user.recoverPassword', ['hash' => $user->token])

	        			];



	        			General::sendTemplateEmail(

	        				$user->email, 

	        				'admin-forgot-password',

	        				$codes

	        			);



	    				$request->session()->flash('success', 'We have sent you a recovery link in your email inbox. Please check your email or spam.');

	    				return redirect()->route('user.forgotPassword');	

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



    	return view("frontend/auth/forgotPassword");

    }



    function recoverPassword(Request $request, $hash)

    {

    	$user = Users::getRow([

    			'token like ?' => [$hash]

    		]);

    	if($user)

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

	        			$user->password = $data['new_password'];

	        			if($user->save())

	        			{

							$codes = [
								'{name}' => $user->first_name,
							];
				
							General::sendTemplateEmail(
								$user->email,
								'change-password',
								$codes
							);

	        				$request->session()->flash('success', 'Password updated successfully. Login with new credentials to proceed.');

		    				return redirect()->route('auth.login');

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

			return view("frontend/auth/recoverPassword");

		}

		else

		{

			abort(404);

		}

    }
	function emailVerification(Request $request, $hash)
	{
		$user = Users::getRow([
			'token like ?' => [$hash],
			'verified_at is null',
			'completed = 1',
			'status = 1'
		]);

		if ($user) {
			//$user->token = null;
			$user->verified_at = date('Y-m-d H:i:s');

			if ($user->save()) {
				$request->session()->flash('success', 'Hooray! Your account verification is completed. Please login to proceed.');
				return redirect()->route('auth.login');
			} else {
				$request->session()->flash('error', 'Email could not be verified. The link is expired or used.');
				return redirect()->route('auth.login');
			}
		} else {
			$request->session()->flash('error', 'Email could not be verified. The link is expired or used.');
			return redirect()->route('auth.login');
		}
	}

	function resendVerificationEmail(Request $request)
	{
		if ($request->get('user_id')) {
			$userID = General::decrypt($request->get('user_id'));

			$token = General::hash(64);

			$user = User::get($userID);

			$link = url('/email-verification') . '/' . $token;
			$codes = [
				'{first_name}' => $user->first_name,
				'{last_name}' => $user->last_name,
				'{email}' => $user->email,
				'{website_link}' => url()->route('homepage.index'),
				'{verification_link}' => General::urlToAnchor($link),
				'{company_name}' => Settings::get('company_name')
			];

			General::sendTemplateEmail(
				$user->email,
				'registration',
				$codes
			);

			return Response()->json([
				'status' => 'success',
				'message' => 'Email Sent!!'
			]);
		} else {
			return Response()->json([
				'status' => 'error',
				'message' => 'Email not sent.'
			]);
		}
	}

	function logout(Request $request)
	{
		$user = UserAuth::getLoginId();
		DB::table('users')
            ->where('id', $user)
            ->update([
                'active_status' => '0',
            ]);

		UserAuth::logout();

		$request->session()->forget('fb_access_token');

		return redirect()->route('auth.login');
	}

	function validateEmail(Request $request)
	{
		$user = Users::select(['id'])
			->where('email', 'LIKE', $request->get('email'))
			->where('completed', 1)
			->first();
		// dd($user);
		echo $user ? 'false' : 'true';
		die;
	}

	function success(Request $request)
	{
		return view("frontend.auth.success", []);
	}

	public function redirectToInstagram()
    {
        return Socialite::driver('instagram')->redirect();
    }

    public function handleInstagramCallback()
    {
    	 dd('callback');
        $user = Socialite::driver('instagram')->user();
       
        // Add your logic here to handle the authenticated user
        // For example, you can log them in or register them in your application.

        return redirect()->route('home'); // Replace 'home' with your desired route after authentication.
    }

    public function redirectToProvider()
	{
	    return Socialite::driver('facebook')->redirect();
	}

	public function handleProviderCallback(Request $request)
	{
	   $user = Socialite::driver('facebook')->user();
	   // dd($user);
	   $exUser = Users::where('social_loginId',$user->id)->first();
	   // dd($exUser);
	    if(!empty($exUser)){
	    	
		    $created_user  = UserAuth::attemptSocialLogin($exUser->id , $exUser->email);
		    $login = UserAuth::makeLoginSession($request, $created_user);

			if($login){
				
				$request->session()->flash('success', 'Login successfully.');
				return redirect()->route('index_user',['id' => General::encrypt($exUser->id)]);
			}else{
				$request->session()->flash('error', 'Session could not be establised. Please try again.');
				return redirect()->back(); 
			}
	    }else{
	    $users = Users::social_createfacebook($user);
	  	$created_user  = UserAuth::attemptSocialLogin($users->id , $users->email);
	    $login = UserAuth::makeLoginSession($request, $created_user);
		$userData = UserAuth::getUser($users->id);

		$allUsersEmail = Users::where('status', 1)
								->where('role', '!=', 'admin')
								->where('email', '!=', $user->email)
								->pluck('email');
	    $codes = [
	                '{first_name}' =>$users->first_name,
					'{profile_url}' => route('UserProfileFrontend', $users->slug),
	            ];
	    General::sendTemplateEmail(
	                        $users->email,
	                        'thankyou-mail',
	                        $codes
	                    );
		// General::sendTemplateEmail(
		// 					$user->email,
		// 					'first-featured-or-bump',
		// 					$codes
		// 				);
		General::sendTemplateEmail(
							$allUsersEmail,
							'new-member-joining',
							$codes
						);
		if($login){
			if ($userData->first_time_login == 1) {
				$request->session()->flash('success', 'Login successfully.');
				return redirect()->route('index_user',['id' => General::encrypt($user->id)]);
			} else {
				$request->session()->flash('login_popup', 'Your first paid listing is free! Simply create a post to see how it works. Thank you for choosing FindersPage.');
				return redirect()->route('index_user', ['token' => $user->token, 'id' => General::encrypt($user->id)]);
			}
		}else{
			$request->session()->flash('error', 'Session could not be establised. Please try again.');
			return redirect()->back(); 
		}
	}
	}



public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback(Request $request)
{
	// dd($request->all());
    $user = Socialite::driver('google')->user();
    //   dd($user);
    	$exUser = Users::where('social_loginId',$user->id)->first();
      // dd($exUser);
	    if(!empty($exUser)){
	    	
		    $created_user  = UserAuth::attemptSocialLogin($exUser->id , $exUser->email);
		    if(empty($created_user->verified_at)){
		    	$googleUser = Users::where('id',$created_user->id)->update(['verified_at' => date('Y-m-d H:i:s')]);
		    }
		    
		    $login = UserAuth::makeLoginSession($request, $created_user);
		    
			if($login){
				$request->session()->flash('success', 'Login successfully.');
				return redirect()->route('index_user',['id' => General::encrypt($exUser->id)]);
			}else{
				$request->session()->flash('error', 'Session could not be establised. Please try again.');
				return redirect()->back(); 
			}
	    }else{
	    $users = Users::social_creategoogle($user);
		// dd($users);
	  	$created_user  = UserAuth::attemptSocialLogin($users->id , $users->email);
	    $login = UserAuth::makeLoginSession($request, $created_user);
		$userData = UserAuth::getUser($users->id);
		
		$allUsersEmail = Users::where('status', 1)
								->where('role', '!=', 'admin')
								->where('email', '!=', $user->email)
								->pluck('email');
		// dd($allUsersEmail);
		// $allUsers = implode(",", $allUsersEmail);
	    $codes = [
	                '{first_name}' =>$users->first_name,
					'{profile_url}' => route('UserProfileFrontend', $users->slug),
	            ];
	    General::sendTemplateEmail(
	                        $users->email,
	                        'thankyou-mail',
	                        $codes
	                    );
		// General::sendTemplateEmail(
		// 					$user->email,
		// 					'first-featured-or-bump',
		// 					$codes
		// 				);
		General::sendTemplateEmail(
							$allUsersEmail,
							'new-member-joining',
							$codes
						);
		if($login){
			if ($userData->first_time_login == 1) {
				$request->session()->flash('success', 'Login successfully.');
				return redirect()->route('index_user',['id' => General::encrypt($user->id)]);
			} else {
				$request->session()->flash('login_popup', 'Your first paid listing is free! Simply create a post to see how it works. Thank you for choosing FindersPage.');
				return redirect()->route('index_user', ['token' => $user->token, 'id' => General::encrypt($user->id)]);
			}
		}else{
			$request->session()->flash('error', 'Session could not be establised. Please try again.');
			return redirect()->back(); 
		}
	}
}

public function blockUser(Request $request)
{
	$block_user = new BlockUser();
    $ex_user = BlockUser::where('block_id', $request->block_id)
                        ->where('block_by', $request->block_by)
                        ->first();
	$blocked_user = Users::select('first_name')
						->where('id', $request->block_id)
						->first();
	$blocked_user_name = $blocked_user->first_name;
    
    if ($ex_user) {
        return response()->json(['block_Id_exists' => 'You have already blocked this user.']);
    }
    
    $block_user = $block_user->add_block_user($request);
    // dd($blocked_user_name);
	return response()->json(['block_success' => 'You blocked this user.', 'blocked_user_name' => $blocked_user_name]);

}

public function unblockUser(Request $request)
{
    $unblock_user = BlockUser::where('block_id', $request->block_id)
                             ->where('block_by', $request->block_by)
                             ->first();
    
    if (!$unblock_user) {
        return response()->json(['Unblock_error' => 'User not found.']);
    }
    
    $unblock_user->delete();
    
    return response()->json(['Unblock_success' => 'You unblocked this user.']);
}


// public function blockgetUser(Request $request){
	
// 	$ex_user = BlockUser::where('block_id',$request->block_id)->where('block_by',$request->block_by)->first();
// 	if($ex_user){
// 		return response()->json(['return_data'=> $ex_user]);
// 	}
// 	else{
// 		return response()->json(['blank'=>'You Block This user.']);
// 	}
// }

// public function blockget_block_by(Request $request){
// 	$authUser = Auth::user()->id; 
// 	$ex_user = BlockUser::where('block_id',$request->block_by)->where('block_by',$request->block_id)->first();
// 	if($ex_user){
// 		return response()->json(['return_data'=> $ex_user]);
// 	}
// 	else{
// 		return response()->json(['blank'=>'No data available block_by']);
// 	}
// }
public function blockget_block_id(Request $request){
	$authUser = Auth::user()->id; 
	$block_id = BlockUser::where('block_id',$authUser)->where('block_by',$request->block_id)->first();
	if($block_id){
		return response()->json(['return_data'=> $block_id]);
	}
	else{
		return response()->json(['blank'=>'No data available.']);
	}
}


public function blockgetUser(Request $request)
{
    $authUser = Auth::user()->id;

    $block_by = BlockUser::where('block_id', $request->block_id)
                         ->where('block_by', $authUser)
                         ->first();

    $blocked_user = Users::select('first_name')
                         ->where('id', $request->block_id)
                         ->first();

    $blocked_user_name = $blocked_user ? $blocked_user->first_name : '';

    // Return JSON response with block information and blocked user's name
    return response()->json([
        'return_block_by' => $block_by,
        'blocked_user_name' => $blocked_user_name
    ]);
}


public function sendOTP(Request $request) {
	$validator = Validator::make(
			    $request->toArray(),
			    [
			        'email' => [
			            'required',
			            'email',
			            Rule::unique('users'),
			            new DnsValidEmail 
			        ] 
			    ],  
			);

	
	if (!$validator->fails()) {
		$otp = mt_rand(100000, 999999); // Generate a 6-digit OTP
    	$email = $request->input('email');
	    // dd($email);
	    // Save the OTP in the session
	    Session::put('otp', $otp);
	    $codes = [
					'{otp}' => $otp,
				];
				// dd($codes);
				General::sendTemplateEmail(
					$email,
					'register-otp',
					$codes
				);

		return response()->json(['success' => 'OTP has been sent. Please kindly check your email inbox.']);
	}else{
		return response()->json(['responseText' => 'OTP can not be send ,Please check your email and try again.']);
	}
    
}




public function bulkDeleteMessage(Request $request)
    {
        $messageIds = $request->input('message_ids');

        if (is_array($messageIds) && !empty($messageIds)) {
            try {
                DB::table('ch_messages')->whereIn('id', $messageIds)->delete();
                return response()->json(['status' => 'success', 'message' => 'Messages deleted successfully.']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred while deleting messages.']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'No valid message ID provided.']);
        }
    }


	

}