<?php
namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;

use App\Models\Admin\Settings;

use App\Models\Admin\Permissions;

use App\Models\Admin\AdminAuth;

use App\Libraries\General;

use App\Libraries\FileSystem;

use App\Libraries\Excel;

use App\Models\Admin\Users;

use App\Models\Admin\Transaction;

use Illuminate\Validation\Rule;

use Illuminate\Support\Str;



class UsersController extends AppController

{

	function __construct()

	{

		parent::__construct();

	}



    function index(Request $request)

    {

    	if(!Permissions::hasPermission('users', 'listing'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$where = [];

    	if($request->get('search'))

    	{

    		$search = $request->get('search');

    		$search = '%' . $search . '%';

    		$where['(concat(users.first_name, "", users.last_name) LIKE ? or users.email LIKE ? or users.phonenumber LIKE ?)'] = [$search, $search, $search];

    	}



    	if($request->get('last_login'))

    	{

    		$lastLogin = $request->get('last_login');

    		if(isset($lastLogin[0]) && !empty($lastLogin[0]))

    			$where['users.last_login >= ?'] = [

    				date('Y-m-d 00:00:00', strtotime($lastLogin[0]))

    			];

    		if(isset($lastLogin[1]) && !empty($lastLogin[1]))

    			$where['users.last_login <= ?'] = [

    				date('Y-m-d 23:59:59', strtotime($lastLogin[1]))

    			];

    	}



    	if($request->get('created_on'))

    	{

    		$created = $request->get('created_on');

    		if(isset($created[0]) && !empty($created[0]))

    			$where['users.created >= ?'] = [

    				date('Y-m-d 00:00:00', strtotime($created[0]))

    			];

    		if(isset($created[1]) && !empty($created[1]))

    			$where['users.created <= ?'] = [

    				date('Y-m-d 23:59:59', strtotime($created[1]))

    			];

    	}



    	if($request->get('role'))

    	{

    		switch ($request->get('role')) {

    			case 'customer':

    				$where['users.seller'] = 0;

    			break;

    			case 'seller':

    				$where['users.seller'] = 1;

    			break;

    		}

    		

    	}



    	if($request->get('status'))

    	{

    		switch ($request->get('status')) {

    			case 'users.active':

    				$where['status'] = 1;

    			break;

    			case 'non_active':

    				$where['users.status'] = 0;

    			break;

    		}    		

    	}



    	$where['users.verified_at != ?'] = [''];



    	$listing = Users::getListing($request, $where);



    	if($request->ajax())

    	{

		    $html = view(

	    		"admin/users/listingLoop", 

	    		[

	    			'listing' => $listing

	    		]

	    	)->render();



		    return Response()->json([

		    	'status' => 'success',

	            'html' => $html,

	            'page' => $listing->currentPage(),

	            'counter' => $listing->perPage(),

	            'count' => $listing->total(),

	           

	        ], 200);

		}

		else

		{

	    	return view(

	    		"admin/users/index", 

	    		[

	    			'listing' => $listing,

	    		]

	    	);

	    }

    }



    function add(Request $request)


    {

    	if(!Permissions::hasPermission('users', 'create'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	if($request->isMethod('post'))

    	{
    	 
    		$data = $request->toArray();

    		unset($data['_token']);

    		/** Set random password in case send email button is on **/

    		$sendPasswordEmail = isset($data['send_password_email']) && $data['send_password_email'] > 0 ? true : false;

        	if($sendPasswordEmail)

        	{

        		$data['password'] = $request->password;

        	}

        	/** Set random password in case send email button is on **/



    		$validator = Validator::make(

	            $data,

	            [

	                'first_name' => 'required',

	                'last_name' => 'required',

	                'email' => [

	                	'required',

	                	'email',

	                	Rule::unique('users')->whereNull('deleted_at')

	                ],

	                'send_password_email' => 'required',

	                'password' => [

	                	'required',

					    'min:8',

	                ]

	            ]

	        );





	        if(!$validator->fails())

	        {

	        	$password = $data['password'];

	        	// unset($data['_token']);
	        	$data['token'] = General::hash(64);
	        	unset($data['send_password_email']);

	        	$data['verified_at'] = date('Y-m-d H:i:s');




	        	// echo "<pre>";print_r($request->password);die();
	        	$user = Users::create($data);



	        	if($user)

	        	{
	        		if ($request->hasFile('image')) {
		            $image11 = $request->file('image');
		            $name = time() . '.' . $image11->getClientOriginalExtension();
		            // dd($name);	
		            $destinationPath = public_path('/assets/images/profile');
		            $image11->move($destinationPath, $name );
		             // dd($name);
		            $user->image = $name;
		            $user->save();
		        	}

	        		//Send Email

	        		if($sendPasswordEmail)

	        		{

	        			$codes = [

	        				'{first_name}' => $user->first_name,
	        				'{email}' => $user->email,
	        				'{password}' => $request->password

	        			];



	        			General::sendTemplateEmail(

	        				$user->email, 

	        				'customer-admin-registration', 

	        				$codes

	        			);



	        		}



	        		$request->session()->flash('success', 'Customer created successfully.');

	        		return redirect()->route('user.users');

	        	}

	        	else

	        	{

	        		$request->session()->flash('error', 'Customer could not be saved. Please try again.');

		    		return redirect()->back()->withErrors($validator)->withInput();

	        	}

		    }

		    else

		    {

		    	$request->session()->flash('error', 'Please provide valid inputs.');

		    	return redirect()->back()->withErrors($validator)->withInput();

		    }

		}

	    

	    return view("admin/users/add", []);

    }



    function edit(Request $request, $id)

    {
    	if(!Permissions::hasPermission('users', 'update'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$user = Users::get($id);

    	if($user)

    	{

	    	if($request->isMethod('post'))

	    	{

	    		$data = $request->toArray();


	    		/** Set random password in case send email button is on **/

	    		$sendPasswordEmail = isset($data['send_password_email']) && $data['send_password_email'] > 0 ? true : false;

	        	if($sendPasswordEmail)

	        	{

	        		$data['password'] = $password = Str::random(20);

	        	}

	        	elseif(!isset($data['password']) || !$data['password'])

	        	{

	        		unset($data['password']);

	        	}



	        	/** Set random password in case send email button is on **/


	    		$validator = Validator::make(

		            $data,

		            [

		                'first_name' => 'required',

		                'last_name' => 'required',

		                'email' => [

		                	'required',

		                	'email',

		                	Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')

		                ],

		                'password' => [

		                	'nullable',

						    'min:8',

		                ],

		            ]

		        );



		        if(!$validator->fails())

		        {
		        	unset($data['_token']);

		        	unset($data['send_password_email']);

		        	$user = Users::modify($id, $data);

		        	if($user)

		        	{
		        	if ($request->hasFile('image')) {
		            $image_update = $request->file('image');
		            $name = time() . '.' . $image_update->getClientOriginalExtension();
		            // dd($name);	
		            $destinationPath = public_path('/assets/images/profile');
		            $image_update->move($destinationPath, $name );
		             // dd($name);
		            $user->image = $name;
		            $user->save();
		        	}
		        		//Send Email

		        		if($sendPasswordEmail)

		        		{

		        			$codes = [

	        				'{first_name}' => $user->first_name,
	        				'{email}' => $user->email,
	        				'{password}' => $request->password

	        			];



		        			General::sendTemplateEmail(

		        				$user->email, 

		        				'customer-admin-registration',

		        				$codes

		        			);

		        		}



		        		$request->session()->flash('success', 'User updated successfully.');

		        		return redirect()->route('user.users');

		        	}

		        	else

		        	{

		        		$request->session()->flash('error', 'User could not be saved. Please try again.');

			    		return redirect()->back()->withErrors($validator)->withInput();

		        	}

			    }

			    else

			    {

			    	$request->session()->flash('error', 'Please provide valid inputs.');

			    	return redirect()->back()->withErrors($validator)->withInput();

			    }

			}



			return view("admin/users/edit", [

    			'user' => $user

    		]);

		}

		else

		{

			abort(404);

		}

    }






    function view(Request $request, $id)

    {

    	if(!Permissions::hasPermission('users', 'listing'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$user = Users::get($id);



    	if($user)

    	{

	    	return view(

	    		"admin/users/view", 

	    		[

	    			'user' => $user

	    		]

	    	);

		}

		else

		{

			abort(404);

		}

    }



    function delete(Request $request, $id)

    {

    	if(!Permissions::hasPermission('users', 'delete'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$user = Users::find($id);

    	

    	if($user)

    	{

	    	if($user->delete())

	    	{

	    		$request->session()->flash('success', 'User deleted successfully.');

	    		return redirect()->route('user.users');

	    	}

	    	else

	    	{

	    		$request->session()->flash('error', 'User category could not be deleted.');

	    		return redirect()->route('user.users');

	    	}

	    }

	    else

	    {

	    	abort(404);

	    }

    }





    function permanent_delete(Request $request, $id)

    {

    	if(!Permissions::hasPermission('users', 'delete'))

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$user = Users::find($id);

			// Check if the user exists
			if ($user) {
			    // Permanently delete the user
			    $user->forceDelete();

			    // Alternatively, you can also use the delete method to soft delete the user
			    // $user->delete();

			    // Additional actions if needed

			    return redirect()->route('user.users')->with('success', 'User permanently deleted.');
			} else {
			    return redirect()->route('user.users')->with('error', 'User not found.');
			}

    }



    function bulkActions(Request $request, $action)

    {

    	if( ($action != 'delete' && !Permissions::hasPermission('users', 'update')) || ($action == 'delete' && !Permissions::hasPermission('users', 'delete')) ) 

    	{

    		$request->session()->flash('error', 'Permission denied.');

    		return redirect()->route('admin.dashboard');

    	}



    	$ids = $request->get('ids');

    	if(is_array($ids) && !empty($ids))

    	{

    		switch ($action) {

    			case 'active':

    				Users::modifyAll($ids, [

    					'status' => 1

    				]);

    				$message = count($ids) . ' records has been activated.';

    			break;

    			case 'inactive':

    				Users::modifyAll($ids, [

    					'status' => 0

    				]);

    				$message = count($ids) . ' records has been inactivated.';

    			break;

    			case 'delete':

    				Users::removeAll($ids);

    				$message = count($ids) . ' records has been deleted.';

    			break;

    		}



    		$request->session()->flash('success', $message);



    		return Response()->json([

    			'status' => 'success',

	            'message' => $message,

	        ], 200);		

    	}

    	else

    	{

    		return Response()->json([

    			'status' => 'error',

	            'message' => 'Please select atleast one record.',

	        ], 200);

    	}

    }



    function updatePicture(Request $request)

    {

    	if(!Permissions::hasPermission('users', 'update'))

    	{

    		return Response()->json([

			    	'status' => 'error',

			    	'message' => 'Permission denied.'

			    ]);

    	}



    	if($request->isMethod('post'))

    	{

    		$data = $request->toArray();



            $validator = Validator::make(

	            $request->toArray(),

	            [

	                'file' => 'mimes:jpg,jpeg,png,gif',

	            ]

	        );



	        if(!$validator->fails())

	        {

				$id = $data['id'];



		    	$user = Users::find($id);

		    	if($user && $user->user_type == 'customer')

		    	{

		    		$oldImage = $user->image;

		    		if($request->file('file')->isValid())

		    		{
		    		// 	if ($request->hasFile('image')) {
		            // $image = $request->file('image');
		            // $name = time() . '.' . $image->getClientOriginalExtension();
		            // $destinationPath = public_path('/assets/images/profile');
		            // $image->move($destinationPath, $name );
		            // $user->image = $name;
		        	// }

		    			$file = FileSystem::uploadImage(

		    				$request->file('file'),

		    				'users'

		    			);



		    			if($file)

		    			{

		    				$user->image = $file;

		    				if($user->save())

		    				{

		    					$originalName = FileSystem::getFileNameFromPath($file);

		    					

		    					FileSystem::resizeImage($file, 'M-' . $originalName, "350*350");

		    					FileSystem::resizeImage($file, 'S-' . $originalName, "100*100");

		    					$picture = $user->getResizeImagesAttribute()['medium'];



		    					if($oldImage)
		    					{

		    						FileSystem::deleteFile($oldImage);

		    					}



		    					

		    					return Response()->json([

							    	'status' => 'success',

							    	'message' => 'Picture uploaded successfully.',

							    	'picture' => url($picture)

							    ]);		

		    				}

		    				else

		    				{

		    					FileSystem::deleteFile($file);

		    					return Response()->json([

							    	'status' => 'error',

							    	'message' => 'Picture could not be uploaded.'

							    ]);	

		    				}

		    				

		    			}

		    			else

		    			{

		    				return Response()->json([

						    	'status' => 'error',

						    	'message' => 'Picture could not be uploaded.'

						    ]);		

		    			}

		    		}

					else

					{

						return Response()->json([

					    	'status' => 'error',

					    	'message' => 'Picture could not be uploaded. Please try again.'

					    ]);

					}

				}

				else

				{

					return Response()->json([

				    	'status' => 'error',

				    	'message' => 'Admin member is missing.'

				    ]);

				}

			}

		}

		else

		{

			return Response()->json([

			    	'status' => 'error',

			    	'message' => 'Admin member is missing.'

			    ]);

		}

    }



    function export(Request $request)

    {

        $data = $request->toArray();

        if($data && isset($data['t']) && $data['t'])

        {

            $headers = [

                "Id",

                "Name",

                "Phonenumber",

                "Gender",

                "DOB",

                "Bio",

                "Address",

                "Zipcode",

                "Created"

            ];

            

            $users = Users::where('users.user_type', '=', 'customer' )->limit(3000);



            

            if($data['t'] == 'all' && isset($data['d']) && $data['d'])

            {

                $users->orderBy('users.created', 'asc');



                $dates = explode('-', $data['d']);

                if(count($dates)  === 2)

                {

                    $users->where('users.created', '>=', date( 'Y-m-d 00:00:01', strtotime($dates[0])) )

                    ->where('users.created', '<=', date( 'Y-m-d 23:59:59', strtotime($dates[1])) );

                }

            }

            elseif($data['t'] == 'filtered')

            {

				$where[] = " users.user_type = 'customer' ";



		    	if($request->get('search'))

		    	{

		    		$search = $request->get('search');

		    		$search = '%' . $search . '%';

		    		$where['(concat(users.first_name, "", users.last_name) LIKE ? or users.email LIKE ? or users.phonenumber LIKE ?)'] = [$search, $search, $search];

		    	}



		    	if($request->get('last_login'))

		    	{

		    		$lastLogin = $request->get('last_login');

		    		if(isset($lastLogin[0]) && !empty($lastLogin[0]))

		    			$where['users.last_login >= ?'] = [

		    				date('Y-m-d 00:00:00', strtotime($lastLogin[0]))

		    			];

		    		if(isset($lastLogin[1]) && !empty($lastLogin[1]))

		    			$where['users.last_login <= ?'] = [

		    				date('Y-m-d 23:59:59', strtotime($lastLogin[1]))

		    			];

		    	}



		    	if($request->get('created_on'))

		    	{

		    		$created = $request->get('created_on');

		    		if(isset($created[0]) && !empty($created[0]))

		    			$where['users.created >= ?'] = [

		    				date('Y-m-d 00:00:00', strtotime($created[0]))

		    			];

		    		if(isset($created[1]) && !empty($created[1]))

		    			$where['users.created <= ?'] = [

		    				date('Y-m-d 23:59:59', strtotime($created[1]))

		    			];

		    	}



		    	if($request->get('status'))

		    	{

		    		switch ($request->get('status')) {

		    			case 'users.active':

		    				$where['status'] = 1;

		    			break;

		    			case 'non_active':

		    				$where['users.status'] = 0;

		    			break;

		    		}    		

		    	}



                foreach($where as $query => $values)

                {

                    if(is_array($values))

                        $users->whereRaw($query, $values);

                    elseif(!is_numeric($query))

                        $users->where($query, $values);

                    else

                        $users->whereRaw($values);

                }

            }

            else

            {

                $users->orderBy('users.id', 'desc');

            }

            

            $data = [];

            

            foreach($users->get() as $u)

            {

                $data[] = [

                    $u->id,

                    $u->first_name . ' ' . $u->last_name,

                    $u->phonenumber,

                    $u->gender,

                    $u->dob,

                    $u->bio,

                    $u->address,

                    $u->zipcode,

                    $u->created,

                ];

            }

            

            Excel::download($data, $headers, 'users.xlsx');

        }

        else

        {

            $request->session()->flash('error', 'Invalid request.');

            return redirect()->route('admin.users');

        }

    }

     function updateUserStatus(Request $request, $id)
    {
    	if(!Permissions::hasPermission('users', 'update'))
    	{
    		$request->session()->flash('error', 'Permission denied.');
    		return redirect()->route('admin.dashboard');
    	}

    	$user = Users::get($id);
    	if($user)
    	{
    		$data = array();
    		$data['status'] = $request->flag;
	    	if($request->isMethod('post'))
	    	{
	    		$user = Users::modify($id, $data);
	    		//$request->session()->flash('success', 'User updated successfully.');
		        //return redirect()->route('admin.users');
		        return Response()->json([
					'status' => 'success',
					'message' => 'User updated successfully.'
				]);
	    	}
		}else
		{
			abort(404);
		}
    }


    public function updatebanstatus(Request $request)
    {
		$userdata = Users::where('id', $request->id)->first();
    	if($request->status == 1){
	    	$user = Users::where('id', $request->id)
	                ->update([
	                    'status' => $request->status,
				]);
			if($user){
				return response()->json(['success' => 'User unblock successfully..!!']);
				
			}else{
				return response()->json(['error' => 'Somthing went wrong...!!']);
			}
		}elseif($request->status == 0){
			$user = Users::where('id', $request->id)
	                ->update([
	                    'status' => $request->status,
				]);
	        if($user){
				// dd($user);
				$codes = [

					'{first_name}' => $userdata->first_name,
				];
				General::sendTemplateEmail(
					$userdata->email, 
					'Account suspended', 
					$codes
				);

				return response()->json(['success' => 'User block successfully..!!']);
				
			}else{
				return response()->json(['error' => 'Somthing went wrong...!!']);
			}
			
		}
    }

}