<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;

class ContactUs extends AppModel
{
    protected $table = 'contact_us';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
    * Faq -> Admins belongsTO relation
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
        $orderBy = $request->get('sort') ? $request->get('sort') : 'contact_us.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = ContactUs::select([
                'contact_us.*',
                'owner.email as owner_email'
                
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'contact_us.created_by')
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
    public static function getAll($select = [], $where = [], $orderBy = 'contact_us.id desc', $limit = null)
    {
        $listing = ContactUs::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'contact_us.*'
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
        $record = ContactUs::where('id', $id)
            ->with([
                'owner' => function($query) {
                    $query->select([
                            'id',
                            'email'
                            
                        ]);
                }
            ])
            ->first();

        return $record;
    }

    /**
    * To get single row by conditions
    * @param $where
    * @param $orderBy
    */
    public static function getRow($where = [], $orderBy = 'contact_us.id desc')
    {
        $record = ContactUs::orderByRaw($orderBy);

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
        $contactus = new ContactUs();

        foreach($data as $k => $v)
        {
            $contactus->{$k} = $v;
        }

        $contactus->created_by = AdminAuth::getLoginId();
        $contactus->created = date('Y-m-d H:i:s');
        $contactus->modified = date('Y-m-d H:i:s');
        if($contactus->save())
        {
            if(isset($data['email']) && $data['email'])
            {
                //$contactus->slug = Str::slug($contactus->email) . '-' . General::encode($contactus->id);
                $contactus->save();
            }

            return $contactus;
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
        $contactus = ContactUs::find($id);
        foreach($data as $k => $v)
        {
            $contactus->{$k} = $v;
        }

        $contactus->modified = date('Y-m-d H:i:s');
        if($contactus->save())
        {
            if(isset($data['email']) && $data['email'])
            {
                //$contactus->slug = Str::slug($contactus->email) . '-' . General::encode($contactus->id);
                $contactus->save();
            }

            return $contactus;
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
            return ContactUs::whereIn('contact_us.id', $ids)
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
        $contactus = ContactUs::find($id);
        return $contactus->delete();
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
            return ContactUs::whereIn('contact_us.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }
}