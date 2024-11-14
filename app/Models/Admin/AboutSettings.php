<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;

class AboutSettings extends AppModel
{
    protected $table = 'aboutus_settings';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
    * AboutSettings -> Admins belongsTO relation
    * 
    * @return Admins
    */
    public function owner()
    {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    /**
    * Get resize images
    *
    * @return array
    */
    
    /**
    * To search and get pagination listing
    * @param Request $request
    * @param $limit
    */

    public static function getListing(Request $request, $where = [])
    {
        $orderBy = $request->get('sort') ? $request->get('sort') : 'aboutus_settings.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = AboutSettings::select([
                'aboutus_settings.*',
                'owner.email as owner_email'
                
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'aboutus_settings.created_by')
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
    public static function getAll($select = [], $where = [], $orderBy = 'aboutus_settings.id desc', $limit = null)
    {
        $listing = AboutSettings::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'aboutus_settings.*'
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
    public static function get($key)
    {
        $record = AboutSettings::where('key', $key)->pluck('value')->first();

        return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'aboutus_settings.id desc')
    {
        $record = AboutSettings::orderByRaw($orderBy);

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
        $aboutsetting = new AboutSettings();

        foreach($data as $k => $v)
        {
            $aboutsetting->{$k} = $v;
        }

        $aboutsetting->created_by = AdminAuth::getLoginId();
        $aboutsetting->created = date('Y-m-d H:i:s');
        $aboutsetting->modified = date('Y-m-d H:i:s');
        if($aboutsetting->save())
        {
            if(isset($data['email']) && $data['email'])
            {
                //$aboutsetting->slug = Str::slug($aboutsetting->email) . '-' . General::encode($aboutsetting->id);
                $aboutsetting->save();
            }

            return $aboutsetting;
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
        $aboutsetting = AboutSettings::find($id);
        foreach($data as $k => $v)
        {
            $aboutsetting->{$k} = $v;
        }

        $aboutsetting->modified = date('Y-m-d H:i:s');
        if($aboutsetting->save())
        {
            if(isset($data['email']) && $data['email'])
            {
               // $aboutsetting->slug = Str::slug($aboutsetting->email) . '-' . General::encode($aboutsetting->id);
                $aboutsetting->save();
            }

            return $aboutsetting;
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
            return AboutSettings::whereIn('aboutus_settings.id', $ids)
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
        $aboutsetting = AboutSettings::find($id);
        return $aboutsetting->delete();
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
            return AboutSettings::whereIn('aboutus_settings.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }

    public static function put($key, $value)
    {
        $option = self::where('key', $key)->limit(1)->first();
        if($option)
        {
            $option->value = $value ? $value : "";
            return $option->save();
        }
        else
        {
            $option = new AboutSettings();
            $option->key = $key;
            $option->value = $value;
            return $option->save();
        }
        return false;
    }
}