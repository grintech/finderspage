<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Libraries\General;
use App\Libraries\FileSystem;

class Slider extends AppModel
{
    protected $table = 'slider';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**** ONLY USE FOR MAIN TALBLES NO NEED TO USE FOR RELATION TABLES OR DROPDOWNS OR SMALL SECTIONS ***/
    use SoftDeletes;
    
    /**
    * Slider -> Admins belongsTO relation
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
        $orderBy = $request->get('sort') ? $request->get('sort') : 'slider.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $slider = $request->get('slider') ? $request->get('slider') : 1;
        $limit = self::$paginationLimit;
        $offset = ($slider - 1) * $limit;
        
        $listing = Slider::select([
                'slider.*',
                'owner.first_name as owner_first_name',
                'owner.last_name as owner_last_name'
            ])
            ->leftJoin('admins as owner', 'owner.id', '=', 'slider.created_by')
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
        if($slider !== null && $slider !== "" && $limit !== null && $limit !== "")
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
    public static function getAll($select = [], $where = [], $orderBy = 'slider.id desc', $limit = null)
    {
        $listing = Slider::orderByRaw($orderBy);

        if(!empty($select))
        {
            $listing->select($select);
        }
        else
        {
            $listing->select([
                'slider.*'
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
        $record = Slider::where('id', $id)
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
    public static function getRow($where = [], $orderBy = 'slider.id desc')
    {
        $record = Slider::orderByRaw($orderBy);

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
        $slider = new Slider();

        foreach($data as $k => $v)
        {
            $slider->{$k} = $v;
        }

        $slider->created_by = AdminAuth::getLoginId();
        $slider->created = date('Y-m-d H:i:s');
        $slider->modified = date('Y-m-d H:i:s');
        if($slider->save())
        {
            if(isset($data['title']) && $data['title'])
            {
                $slider->slug = Str::slug($slider->title) . '-' . General::encode($slider->id);
                $slider->save();
            }

            return $slider;
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
        $slider = Slider::find($id);

        foreach($data as $k => $v)
        {
            $slider->{$k} = $v;
        }

        $slider->modified = date('Y-m-d H:i:s');
        if($slider->save())
        {
            return $slider;
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
            return Slider::whereIn('slider.id', $ids)
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
        $slider = Slider::find($id);
        return $slider->delete();
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
            return Slider::whereIn('slider.id', $ids)
                    ->delete();
        }
        else
        {
            return null;
        }

    }

    public static function handleCategories($id, $categories)
    {
        //Delete all first
        BlogCategoryRelation::where('blog_id', $id)->delete();
        // Then Save
        foreach($categories as $c)
        {
            $relation = new BlogCategoryRelation();
            $relation->blog_id = $id;
            $relation->category_id = $c;
            $relation->save();
        }
    }
}