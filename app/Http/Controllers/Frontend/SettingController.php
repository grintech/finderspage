<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Libraries\General;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $userid = UserAuth::getLoginId();
        $setting = Setting::where('user_id',$userid)->get();
        return view('frontend.setting.setting',compact('userid','setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Zodiac_setting(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $settingName = 'zodiac_section';
        $settingValue = $request->zodiac_section;
        $userid = UserAuth::getLoginId();

        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
            // Add other columns and values as needed
        ];

       $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );

        if ($setting->wasRecentlyCreated) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        }
    }



    public function share_btn_setting(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $settingName = 'share_btn';
        $settingValue = $request->share_btn_value;
        $userid = UserAuth::getLoginId();

        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
            // Add other columns and values as needed
        ];

       $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );

        if ($setting->wasRecentlyCreated) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        }
    }


    public function Views_setting(Request $request)
    {
        // dd($request->all());
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $settingName = 'no_of_views';
        $settingValue = $request->views;
        $userid = UserAuth::getLoginId();

        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
            // Add other columns and values as needed
        ];

       $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );

        if ($setting->wasRecentlyCreated) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        }
    }


    public function comment_setting(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $settingName = 'comments_option';
        $settingValue = $request->comments_option;
        $userid = UserAuth::getLoginId();

        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
            // Add other columns and values as needed
        ];

       $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );

        if ($setting->wasRecentlyCreated) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        }
    }

    public function updateSetting(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
    
        $settingName = $request->option_name;
        $settingValue = $request->option_value;
        $userid = UserAuth::getLoginId();
    
        $existingSetting = Setting::where('user_id', $userid)
                                   ->where('setting_name', $settingName)
                                   ->first();
    
        if ($existingSetting) {
            $existingSetting->setting_value = $settingValue;
            $existingSetting->save();
            return response()->json(['message' => 'Setting updated successfully.'], 200);
        } else {
            Setting::create([
                'user_id' => $userid,
                'setting_name' => $settingName,
                'setting_value' => $settingValue,
            ]);
            return response()->json(['message' => 'Setting created successfully.'], 201);
        }
    }
    
    public function account_type(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd($request->account);

        $settingName = 'account';
        $settingValue = $request->account;
        $userid = UserAuth::getLoginId();
        $userData = UserAuth::getLoginUser();
       
        $data = [
            'user_id' => $userid,
            'setting_name' => $settingName,
            'setting_value' => $settingValue,
            // Add other columns and values as needed
        ];
        $oldSetting = Setting::where('user_id',$userid)->first();
         // dd($oldSetting);
        if(!empty($oldSetting)){
            $setting = Setting::updateOrCreate(
            [
                'setting_name' => $settingName,
            ],
            $data
        );
        }else{
          $setting = Setting::Create(
                [
                'user_id' => $userid,
                'setting_name' => $settingName,
                'setting_value' => $settingValue,
            ],
            );
        }
       
        if($request->account =="Public"){
             $codes = [
                        '{first_name}' => $userData->first_name,
                    ];

                    General::sendTemplateEmail(
                        $userData->email,
                        'account-private',
                        $codes
                    );
            }
        if (empty($oldSetting) ) {
            // The record was created
            return response()->json(['message' => 'Setting created successfully.'], 201);
        } else {
          
            // The record was updated
            return response()->json(['message' => 'Setting updated successfully.'], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_tag_at(Request $request,$id)
    {
        $updateTag = Users::find($id);
        if ($updateTag) {
            // Update the 'read' column to 1
           Users::where('id',$id)->update(['tag_at' => $request->tag]);
            return response()->json(['success' => true, 'message' => 'Updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Somthing went wrong.']);
        }
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




}
