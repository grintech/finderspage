<?php

namespace App\Http\Controllers\Frontend;

use App\Libraries\General;
use App\Models\Admin\ProfileCategory;
use App\Models\Admin\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessRegistrationController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function businessRegistration(Request $request, $token, $id)
    {

        // if(UserAuth::isLogin())
        // {
        //     return redirect()->route('homepage.index');
        // }

        $user = Users::where('token', $token)->where('id', General::decrypt($id))->first();

        $user_update = Users::where(['id' => $user->id])->first();
        $user_update->first_time_login = '1';
        $user_update->update();

        if ($request->isMethod('post')) {
            $data = $request->toArray();
            unset($data['_token']);
            $validator = Validator::make(
                $request->toArray(),
                [
                    'business_name' => 'required',
                    'business_email' => [
                        'email',
                    ],
                ]
            );
            if (!$validator->fails()) {
                $data['token'] = General::hash(64);
                $data['completed'] = 1;
                $data['verified_at'] = 1;
                $data['status'] = 1;
                $user = Users::modify($user->id, $data);

                if ($user) {
                    $link = url('/email-verification') . '/' . $data['token'];
                    $codes = [
                        '{name}' => $user->first_name,
                        '{verification_link}' => General::urlToAnchor($link),
                        '{business_name}' => $user->business_name,
                        '{business_email}' => $user->business_email,
                        '{business_phone}' => $user->business_phone,
                        '{business_website}' => $user->business_website,
                        '{business_address}' => $user->business_address,
                    ];

                    General::sendTemplateEmail(
                        $user->email,
                        'business-registration',
                        $codes
                    );

                    //Auth::loginUsingId($user->id);
                    $request->session()->flash('success', 'Thanks for completing your business page information.');
                    return redirect()->route('post.create');
                } else {
                    $request->session()->flash('error', 'Account could not be created. Please try again.');
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            } else {
                $request->session()->flash('error', 'Please provide valid inputs.');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        return view("frontend.auth.businessRegistration", ['user' => $user]);
    }

    public function getBusinessCategory(Request $request)
    {
        $search =  trim($request->q);
        $result = ProfileCategory::where('category', 'LIKE', '%' .  $search . '%')->where('user_roles', 'business')->limit(10)->get();
        return response()->json($result);
        // return response()->json($result);
        // foreach ($result as $country) {
        //     return '<li onclick="selectCountry(' . $country->category . ')">'. $country->category .'</li>';

        // }

    }
}
