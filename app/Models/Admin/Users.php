<?php
namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Admin\Notification;

use App\Models\AppModel;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Libraries\FileSystem;

use Illuminate\Support\Str;

use App\Models\Admin\Categories;

use App\Models\Admin\CreatorAbout;

use App\Libraries\General;

class Users extends  Authenticatable

{
    
    use HasFactory, Notifiable;
    
    protected $table = 'users';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public static $paginationLimit = 1000;

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/

    use SoftDeletes;
    


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

    * Get resize cover images

    *

    * @return array

    */

    public function getResizeCoverAttribute()

    {

        return $this->cover_image ? FileSystem::getAllSizeImages($this->cover_image) : null;

    }

    

    /**

    * Name getter

    */

    function getNameAttribute()

    {

    	return $this->first_name . ' ' . $this->last_name;

    }

    

    /**

    * Password setter

    * @param $value

    */

    function setPasswordAttribute($value)

    {

        return $this->attributes['password'] = Hash::make($value);

    }

    

    /**

    * To search and get pagination listing

    * @param Request $request

    * @param $limit

    */



    public static function getListing(Request $request, $where = [])

    {

    	$orderBy = $request->get('sort') ? $request->get('sort') : 'users.id';

    	$direction = $request->get('direction') ? $request->get('direction') : 'desc';

    	$page = $request->get('page') ? $request->get('page') : 1;

    	$limit = self::$paginationLimit;

    	$offset = ($page - 1) * $limit;

    	$listing = Users::select([

	    		'users.*',

	    	])

	    	->orderBy($orderBy, $direction);



	    if(!empty($where))

	    {

	    	foreach($where as $query => $values)

	    	{

	    		if(is_array($values))

                    $listing->whereRaw($query, $values);

                elseif(!is_numeric($query))

                    $listing->where($query, $values);

                else

                    $listing->whereRaw($values);

	    	}

	    }



	    // Put offset and limit in case of pagination

	    if($page !== null && $page !== "" && $limit !== null && $limit !== "")

	    {

	    	$listing->offset($offset);

	    	$listing->limit($limit);

	    }



	    $listing = $listing->paginate($limit);



	    return $listing;

    }



    /**

    * To get all records

    * @param $where

    * @param $orderBy

    * @param $limit

    */

    public static function getAll($select = [], $where = [], $orderBy = 'users.id desc', $limit = null)

    {

    	$listing = Users::orderByRaw($orderBy);



    	if(!empty($select))

    	{

    		$listing->select($select);

    	}

    	else

    	{

    		$listing->select([

    			'users.*',

    		]);	

    	}



	    if(!empty($where))

	    {

	    	foreach($where as $query => $values)

	    	{

	    		if(is_array($values))

                    $listing->whereRaw($query, $values);

                elseif(!is_numeric($query))

                    $listing->where($query, $values);

                else

                    $listing->whereRaw($values);

	    	}

	    }

	    

	    if($limit !== null && $limit !== "")

	    {

	    	$listing->limit($limit);

	    }



	    $listing = $listing->get();



	    return $listing;

    }



    /**

    * To get single record by id

    * @param $id

    */

    public static function get($id)

    {

    	$record = Users::select([

                'users.*'

            ])

        ->find($id);



	    return $record;

    }



    /**

    * To get single row by conditions

    * @param $where

    * @param $orderBy

    */

    public static function getRow($where = [], $orderBy = 'users.id desc')

    {

    	$record = Users::orderByRaw($orderBy);



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

    * To insert

    * @param $where

    * @param $orderBy

    */

    public static function create($data)

    {
         // dd($data);
    	$user = new Users();
        $lastInsertedId = Users::orderBy('id', 'desc')->value('id');


    	foreach($data as $k => $v)

    	{

    		$user->{$k} = $v;

    	}

        $title = $data['username'];

            // Convert title to lowercase
            $slug = strtolower($title);

            // Replace spaces with hyphens or underscores
            $slug = str_replace(' ', '-', $slug);

            // Remove special characters or non-alphanumeric characters
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
  
        $user->id = $lastInsertedId+1;

        $user->slug = $slug;

        $user->status = 1;

        $user->created_by = AdminAuth::getLoginId();

    	$user->created = date('Y-m-d H:i:s');

        $user->first_time_login = 0;   

    	$user->modified = date('Y-m-d H:i:s');

        

	    if($user->save())
	    {
            if(isset($data['first_name']) && $data['first_name'])
            {

                $user->username = $data['username'];

                $user->save();

            }



	    	return $user;

	    }

	    else

	    {

	    	return null;

	    }

    }



    public static function social_createfacebook($data)

    {
        unset($data->user);
        unset($data->attributes);
        unset($data->approvedScopes);
        unset($data->nickname);
        unset($data->avatar);
        unset($data->refreshToken);
        unset($data->expiresIn);
        $user = new Users();
        $lastInsertedId = Users::orderBy('id', 'desc')->value('id');
        $newdata = [
                    'id' => $lastInsertedId+1,
                    'first_name' => $data->name,
                    'email' => $data->email,
                    'token' => $data->token,
                    'social_loginId' => $data->id,
                ];
        foreach($newdata as $k => $v)

        {

            $user->{$k} = $v;

        } 
        $user->status = 1;
        $user->created = date('Y-m-d H:i:s');
        $user->first_time_login = 0; 
        $user->modified = date('Y-m-d H:i:s');
        if($user->save())
        {
            if(isset($data->name) && $data->name)
            {

                $user->username = $data->name;

                $user->save();

            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'user',
                'message' => 'New account is created by this user ' . $user->username . '.',
            ];
            Notification::create($notice);

            return $user;

        }

        else

        {

            return null;

        }

    }



    public static function social_creategoogle($data)
    {
        $name = $data->name;
        $slug = strtolower($name);
        $slug = str_replace(' ', '-', $slug);
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        $user = new self();

        $user->first_name = $data->name;
        $user->email = $data->email;
        $user->token = $data->token;
        $user->verified_at = now();
        $user->social_loginId = $data->id;
        $user->slug = $slug;
        $user->role = 'business';
        $user->avatar = $data->avatar;
        $user->completed = 1;
        $user->status = 1;
        $user->first_time_login = 0;
        $user->created = now();
        $user->modified = now();

        if ($user->save()) {
            if (isset($data->name) && $data->name) {
                $user->username = $data->name;
                $user->save();
            }

            $notice = [
                'from_id' => $user->id,
                'to_id' => 7,
                'type' => 'user',
                'message' => 'New account is created by this user ' . $user->username . '.',
            ];
            Notification::create($notice);

            // $codes = [
            //     '{name}' => $user->username,
            // ];

            // General::sendTemplateEmail(
            //     $user->email,
            //     'first-featured-or-bump',
            //     $codes
            // );
    
            return $user;
        } else {
            return null;
        }
    }
    


    /**

    * To update

    * @param $id

    * @param $where

    */

    public static function modify($id, $data)

    {
    	$user = Users::find($id);

    	foreach($data as $k => $v)

    	{

    		$uers->{$k} = $v;

    	}



    	$user->modified = date('Y-m-d H:i:s');

	    if($user->save())

	    {

	    	return $user;

	    }

	    else

	    {

	    	return null;

	    }

    }



    

    /**

    * To update all

    * @param $id

    * @param $where

    */

    public static function modifyAll($ids, $data)

    {

    	if(!empty($ids))

    	{

    		return Users::whereIn('users.id', $ids)

		    		->update($data);

	    }

	    else

	    {

	    	return null;

	    }



    }



    /**

    * To delete

    * @param $id

    */

    public static function remove($id)

    {

    	$user = Users::find($id);

    	return $user->delete();

    }



    /**

    * To delete all

    * @param $id

    * @param $where

    */

    public static function removeAll($ids)

    {

    	if(!empty($ids))

    	{

    		return Users::whereIn('users.id', $ids)

		    		->delete();

	    }

	    else

	    {

	    	return null;

	    }



    }



    /**

    * To get count

    * @param $id

    */

    public static function getCount($where = [])

    {

        $record = Users::select([

                DB::raw('COUNT(users.id) as count'),

            ]);



        if(!empty($where))

        {

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

        }



        return $record;

    }

}