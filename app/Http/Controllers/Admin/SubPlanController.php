<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SubPlan;

class SubPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plan = SubPlan::all();
       return view('admin.subscriptionPlan.list',compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriptionPlan.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $rules = [
            'plan' => 'required',
            'price' => 'required',
            'feature_listing' => 'required',
        ];

        // Define custom error messages
        $messages = [
            'plan.required' => 'The plan field is required.',
            'price.required' => 'The price field is required.',
            'feature_listing.required' => 'The feature listing field is required.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plan = new SubPlan();
        $plan = $plan->createPlans($request);

        if ($plan) {
            return redirect()->back()->with(['error' => 'Something went wrong.']);
           
        } else {
             return redirect()->route('sub-plan.list')->with(['success' => 'Plan created successfully.']);
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = SubPlan::find($id);
        return view('admin.subscriptionPlan.edit',compact('plan'));
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
        $rules = [
            'price' => 'required',
            'feature_listing' => 'required',
        ];

        // Define custom error messages
        $messages = [
            'price.required' => 'The price field is required.',
            'feature_listing.required' => 'The feature listing field is required.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $plan = SubPlan::find($id);
        $plan = $plan->updatePlans($request,$id);

        if ($plan) {
            return redirect()->back()->with(['error' => 'Something went wrong.']);
           
        } else {
             return redirect()->route('sub-plan.list')->with(['success' => 'Plan created successfully.']);
        }  
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
