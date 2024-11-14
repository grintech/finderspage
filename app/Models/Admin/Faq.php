<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;

class Faq extends AppModel
{
    protected $table = 'faqs';
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
        $orderBy = $request->get('sort') ? $request->get('sort') : 'faqs.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = self::$paginationLimit;
        $offset = ($page - 1) * $limit;
        
        $listing = Faq::select([
                'faqs.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name'
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'faqs.created_by')
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
    public static function getAll($select = [], $where = [], $orderBy = 'faqs.id desc', $limit = null)
    {
        $listing = Faq::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'faqs.*'
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
        $record = Faq::where('id', $id)
            ->with([
                'owner' => function($query) {
                    $query->select([
                            'id',
                            'first_name',
                            'last_name'
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
    public static function getRow($where = [], $orderBy = 'faqs.id desc')
    {
        $record = Faq::orderByRaw($orderBy);

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
        $faq = new Faq();

        foreach($data as $k => $v)
        {
            $faq->{$k} = $v;
        }

        $faq->created_by = AdminAuth::getLoginId();
        $faq->created = date('Y-m-d H:i:s');
        $faq->modified = date('Y-m-d H:i:s');
        if($faq->save())
        {
            if(isset($data['title']) && $data['title'])
            {
                $faq->slug = Str::slug($faq->title) . '-' . General::encode($faq->id);
                $faq->save();
            }

            return $faq;
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
        $faq = Faq::find($id);
        foreach($data as $k => $v)
        {
            $faq->{$k} = $v;
        }

        $faq->modified = date('Y-m-d H:i:s');
        if($faq->save())
        {
            if(isset($data['title']) && $data['title'])
            {
                $faq->slug = Str::slug($faq->title) . '-' . General::encode($faq->id);
                $faq->save();
            }

            return $faq;
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
            return Faq::whereIn('faqs.id', $ids)
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
        $faq = Faq::find($id);
        return $faq->delete();
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
            return Faq::whereIn('faqs.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }
    }
}