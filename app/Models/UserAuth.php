<?php



namespace App\Models;



use App\Models\AppModel;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

use App\Models\Admin\Users;

use App\Models\API\UsersTokens;

use App\Models\Admin\Settings;


use App\Libraries\FileSystem;

use App\Libraries\General;



class UserAuth extends User

{

    

    protected $table = 'users';
    
    protected $primaryKey = 'id';

    public $timestamps = false;



    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/

    //use SoftDeletes;



    /**

    * Get resize images

    *

    * @return array

    */



    

    
        
    

    public function getResizeImagesAttribute()

    {

        return $this->image ? FileSystem::getAllSizeImages($this->image) : null;

    }



    /**

    * To get single row by conditions

    * @param $where

    * @param $orderBy

    */

    public static function getRow($where = [], $orderBy = 'cc_users.id desc')

    {

        $record = UserAuth::orderByRaw($orderBy);



        foreach($where as $query => $values)

        {

            if(is_array($values))

                $record->whereRaw($query, $values);

            elseif(!is_numeric($query))

                $record->where($query, $values);

            else

                $record->whereRaw($values);

        }

        

        $record = $record->limit(1)->first();



        return $record;

    }



    /**

    * To make admin login

    * @param Request $request

    */

    public static function attemptLogin(Request $request)
{
    // $user = UserAuth::where(function ($query) use ($request) {
    //         $query->where('email', 'LIKE', $request->get('email'))
    //               ->orWhere('username', 'LIKE', $request->get('email'));
    //     })
    //     ->whereIn('completed', array(0, 1))
    //     ->first();

    // if ($user) {
    //     if (Hash::check($request->get('password'), $user->password)) {
    //         return $user;
    //     }
    // }

    // return null;

    // Retrieve the email or username from the request
    $credentials = $request->only(['email', 'password']);

    // Attempt to authenticate the user using Laravel's Auth::attempt
    if (Auth::attempt($credentials, $request->has('remember'))) {
        // Authentication successful, return the authenticated user
        return Auth::user();
    }

    // Authentication failed, return null
    return null;

}

public static function attemptLoginId($id , $email)

    {

        //Get user

        $user = UserAuth::where('id', 'LIKE', $id)

            ->whereIn('completed', array(0,1))

            ->first();

        if($user)

        {

            if($email == $user->email)

            {

                return $user;

            }

        }



        return null;

    }


    public static function attemptSocialLogin($id , $email)
    {

        //Get user

        $user = UserAuth::where('id', 'LIKE', $id)

            ->whereIn('completed', array(0,1))

            ->first();

        if($user)
        {

            if($email == $user->email)

            {

                return $user;

            }

        }



        return null;

    }


    public static function makeLoginSession(Request $request, $user)

    {

        //Make login
        // dd($user);
        if($user)

        {
           
          Auth::guard('user')->login($user);

            if(Auth::guard('user')->check())

            {
                
                $request->session()->regenerate();

                $user->last_login = date('Y-m-d H:i:s');

                $user->save();

                return $user;

            }

        }

        return null;

    }



    public static function isLogin()

    {

        return Auth::guard('user')->check();

    }



    public static function isUser()

    {

        return Auth::guard('user')->user()->is_admin;

    }



    public static function getLoginId()

    {

        $user = Auth::guard('user')->user();

        return $user ? $user->id : null;

    }



    public static function getLoginUserName()

    {

        $user = Auth::guard('user')->user();

        return $user ? $user->name . ' ' . $user->last_name : null;

    }



    public static function getLoginUserType()

    {

        $user = Auth::guard('user')->user();

        return $user ? $user->user_type : null;

    }



    public static function getLoginUserImage()

    {

        $user = Auth::guard('user')->user();

        return $user && $user->image ? $user->image : null;

    }



    public static function getLoginUser()

    {

        $user = Auth::guard('user')->user();

        return $user ? $user : null;

    }



     public static function getLoginToken()

    {

        $user = Auth::guard('user')->user();

        return $user && $user->token ? $user->token : null;

    }



    public static function logout()

    {

        return Auth::guard('user')->logout();

        UsersTokens::where('user_id', $id)->where('device_type', 'web')->delete();

    }



    public static function getToken()

    {

        $id = UserAuth::getLoginId();

        $exist = UsersTokens::where('user_id', $id)->where('device_type', 'web')->where('expire_on', '>', date('Y-m-d H:i:s'))->first();

        return $exist ? $exist->token : null;

    }


    public static function getUserSlug($id)
    {
        $userSlug = Users::select('slug')
                         ->where('id', $id)
                         ->first(); // Use first() to get a single record

        return $userSlug;
    }

    public static function get_user_id_from_slug($slug)
    {
        $userid = Users::select('id')
                         ->where('slug', $slug)
                         ->first(); // Use first() to get a single record

        return $userid;
    }

    public static function getUser($id)
    {
        return Users::find($id);
    }

    public static function getUserRole($id)
    {
        $role = Users::select('role')
                        ->where('id', $id)
                        ->first();
        return $role;
    }
    

}

