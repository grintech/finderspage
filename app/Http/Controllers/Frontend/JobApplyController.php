<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApply;
use App\Models\UserAuth;
use App\Models\Blogs;
use App\Models\Entertainment;
use App\Libraries\General;

class JobApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Blogs::join('jobapply', 'blogs.id', '=', 'jobapply.job_id')
                        ->where('blogs.user_id',UserAuth::getLoginId())
                      ->select('blogs.title','blogs.image1','blogs.status','jobapply.id','jobapply.email','blogs.user_id','jobapply.file','jobapply.phone_no','jobapply.cover_letter' ,'jobapply.created_at','jobapply.job_id','jobapply.applicant_id')  // Select the desired columns from Bolog
                      ->get();
        return view('frontend.dashboard_pages.applybyUser',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($job_id)
    {
        $apply = JobApply::where('job_id',$job_id)->first();
        if($apply->type =='job'){
            $data = Blogs::join('jobapply', 'blogs.id', '=', 'jobapply.job_id')->where('jobapply.job_id',$job_id)
                      ->select('blogs.title','blogs.image1','blogs.slug','blogs.status','jobapply.id','jobapply.email','blogs.user_id','jobapply.file','jobapply.phone_no','jobapply.cover_letter', 'jobapply.created_at','jobapply.job_id','jobapply.applicant_id')  // Select the desired columns from Bolog
                      ->get();
        }elseif($apply->type =='entertainment'){
            $data = Entertainment::join('jobapply', 'Entertainment.id', '=', 'jobapply.job_id')->where('jobapply.job_id',$job_id)
            ->select('Entertainment.title','Entertainment.image','Entertainment.slug','Entertainment.status','jobapply.id','jobapply.email','Entertainment.user_id','jobapply.file','jobapply.phone_no','jobapply.cover_letter', 'jobapply.created_at','jobapply.job_id','jobapply.applicant_id')  // Select the desired columns from Bolog
            ->get();
        }
        
         // dd($data);
        return view('frontend.dashboard_pages.apliedJobList',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apply = new JobApply();
       $applied_job = JobApply::where('applicant_id', UserAuth::getLoginId())
                      ->where('job_id', $request->job_id)
                      ->first();
        if($applied_job){
            if($applied_job->type == "job"){
                $request->session()->flash('error', 'You have already applied for this listing. Thank you.');
                return redirect()->back();
            }elseif($applied_job->type == "entertainment"){
                $request->session()->flash('error', 'You have already applied for this listing. Thank you.');
                return redirect()->back();
            }
            
        }

        $apply = $apply->applyJob($request);
        if(empty($apply)){
            $codes = [
                        '{name}' => $request->first_name,
                        '{job_url}' => "https://www.finderspage.com/job-post/hello-world-ZMZbgM",
                        ];
  
                        General::sendTemplateEmail(
                            $request->email,
                            'apply-job',
                            $codes
                        );
        if($request->type == "job"){
            $request->session()->flash('success', 'Thank you for applying for this job.');
            return redirect()->back();
        }elseif($request->type == "entertainment"){
            $request->session()->flash('success', 'Thank you for applying for this listing.');
            return redirect()->back();
        }
           
        }else{
             $request->session()->flash('error', 'Somthing went wrong. please try again later. Thanks.');
                return redirect()->back();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $apply = JobApply::find($id);
       // dd($apply);
       return view('frontend.dashboard_pages.apliedJobEdit',compact('apply')); 
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
      $apply = JobApply::find($id);
      $apply = $apply->applyJob_update($request,$id);
      if(empty($apply)){
            $request->session()->flash('success', 'Data updated successfully..!!');
            return redirect()->route('apply.list');
           
        }else{
             $request->session()->flash('error', 'Somthing went wrong. please try again later. Thanks.');
                return redirect()->back();
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
       $apply = JobApply::find($id);
       $apply = $apply->delete();
       if(empty($apply)){
            
            return redirect()->route('apply.list');
           
        }else{
            
                return redirect()->back();
        }
    }
}
