<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPlan extends Model
{
    use HasFactory;

    protected $table ="sub_plans";
    protected $fillable =['plan','price','feature_listing','slideshow','status'];



    public function createPlans($request){
        self::create([
                        'plan' => $request->plan,
                        'price' => $request->price,
                        'feature_listing' => $request->feature_listing,
                        'slideshow' => $request->slideshow,
                    ]);
    }

    public function updatePlans($request,$id){
        $this::update([
                        'price' => $request->price,
                        'feature_listing' => $request->feature_listing,
                        'slideshow' => $request->slideshow,
                    ]);
    }
}
