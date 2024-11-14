<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use App\Models\Admin\PurchasedPlans;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;

class UsersPlans extends AppModel
{
    protected $table = 'users_plans';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;
    
    /**
    * UsersPlans -> Admins belongsTO relation
    * 
    * @return Admins
    */
    public function owner()
    {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

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
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [])
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'users_plans.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = UsersPlans::select([
                'users_plans.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name',
                'creator.first_name as creator_first_name',
                'creator.last_name as creator_last_name',
                'mp.currency as currency',
                'mp.days as days',
                'mp.currenct_code as currenct_code',
                'mp.features as features',
                'mp.price_range as price_range'
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'users_plans.created_by')
            ->leftJoin('users as creator', 'creator.id', '=', 'users_plans.user_id')
            ->leftJoin('membership_plans as mp', 'mp.id', '=', 'users_plans.plan_id')
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

        foreach ($listing as $key => $l) {
                
            $whereMembers[]             = " purchased_plans.plan_id = ".$l['id']."";
            $whereMembers[]             = " purchased_plans.expiry_date >= '".date('Y-m-d')."' ";
            $listing[$key]['members']   = PurchasedPlans::getCount($whereMembers);

            $whereMembers = [];
        }
        
        return $listing;
    }

    /**
    * To get all records
    * @param $where
    * @param $orderBy
    * @param $limit
    */
    public static function getAll($select = [], $where = [], $orderBy = 'users_plans.id desc', $limit = null)
    {
        $listing = UsersPlans::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'users_plans.*'
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
        $record = UsersPlans::select([
                'users_plans.*',
                'mp.currency as currency',
                'mp.days as days',
                'mp.currenct_code as currenct_code',
                'mp.features as features',
                'mp.price_range as price_range'
            ])
            ->where('users_plans.id', $id)
            ->with([
                'owner' => function($query) {
                    $query->select([
                            'id',
                            'first_name',
                            'last_name'
                        ]);
                }
            ])
            ->with([
                'creator' => function($query) {
                    $query->select([
                            'id',
                            'first_name',
                            'last_name'
                        ]);
                }
            ])
            ->leftJoin('membership_plans as mp', 'mp.id', '=', 'users_plans.plan_id')
            ->first();

        return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'users_plans.id desc')
    {
        $record = UsersPlans::select([
                'users_plans.*',
                'mp.currency as currency',
                'mp.days as days',
                'mp.currenct_code as currenct_code',
                'mp.features as features',
                'mp.price_range as price_range'
            ])
            ->leftJoin('membership_plans as mp', 'mp.id', '=', 'users_plans.plan_id')
            ->orderByRaw($orderBy);

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
        $users_plans = new UsersPlans();

        foreach($data as $k => $v)
        {
            $users_plans->{$k} = $v;
        }

        $users_plans->created_by = AdminAuth::getLoginId();
        $users_plans->created = date('Y-m-d H:i:s');
        $users_plans->modified = date('Y-m-d H:i:s');
        if($users_plans->save())
        {
            return $users_plans;
        }
        else
        {
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
        $users_plans = UsersPlans::find($id);
        foreach($data as $k => $v)
        {
            $users_plans->{$k} = $v;
        }

        $users_plans->modified = date('Y-m-d H:i:s');
        if($users_plans->save())
        {
            return $users_plans;
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
            return UsersPlans::whereIn('users_plans.id', $ids)
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
        $users_plans = UsersPlans::find($id);
        return $users_plans->delete();
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
            return UsersPlans::whereIn('users_plans.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }

    public static function createCreatorPlans($memberships,$user)
    {
        if(isset($memberships) && $memberships && isset($user) && $user)
        {
            foreach ($memberships as $key => $m) {
                
                $data['title']          = $m['title'];
                $data['price']          = $m['price'];
                $data['description']    = $m['description'];
                $data['user_id']        = $user['id'];
                $data['plan_id']        = $m['id'];

                $plan[] = self::create($data);

                $data = [];
            }

            if($plan)
            {
                return $plan;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}