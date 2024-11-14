<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\UserAuth;
use Carbon\Carbon;
use DB;

class ResumeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
      
       return view('frontend.dashboard_pages.resume');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $id = UserAuth::getLoginId();
        $resume = Resume::where('user_id',$id)->get();
        // dd($resume);
       return view('frontend.dashboard_pages.resumeList',compact('resume'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = new Resume();
        $id = UserAuth::getLoginId();
        $oldresume = Resume::where('user_id',$id)->first();
        if(!empty($oldresume)){
           $oldresume = $oldresume->UpdateResume($request , $id);
           if($oldresume){
             $request->session()->flash('error', 'Resume could not be updated. Please try again.');
                    return redirect()->back()->withErrors('error');
        }
             $request->session()->flash('success', 'Your resume is updated Successfully!!.');
                    return redirect()->route('resume.list');      
        }
        $resume = $resume->createResume($request);

        if($resume){
           
             $request->session()->flash('error', 'Resume could not be save. Please try again.');
                    return redirect()->back()->withErrors('error');

        }
       $request->session()->flash('success', 'Your resume is created Successfully!!.');
                    return redirect()->route('resume.list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = Resume::find($id);
        //dd($resume);
        $countries = Country::where('id','233')->get();
        return view('frontend.dashboard_pages.single_resume',compact('resume','countries'));
    }


    public function listingResume()
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = Resume::all();
        // dd($resume);
        $countries = Country::where('id','233')->get();
        $existingRecord = DB::table('saved_post')->get();
        return view('frontend.resume.resumeList',compact('resume','countries','existingRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = Resume::find($id);
        $countries = Country::where('id','233')->get();
        return view('frontend.dashboard_pages.edit_resume',compact('resume','countries'));
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
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = Resume::find($id);
        $resume = $resume->UpdateResume($request , $id);

        if($resume){
           
             $request->session()->flash('error', 'Resume could not be save. Please try again.');
                    return redirect()->back()->withErrors('error');

        }
       $request->session()->flash('success', 'Your resume is updatd successfully!!.');
                    return redirect()->route('resume.list');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        $resume = Resume::find($id); 
        $resume = $resume->delete(); 
        if($resume){
        // $request->session()->flash('error', 'Resume could not be Delete. Please try again.');
                    return redirect()->back()->withErrors('error');

        }
       // $request->session()->flash('success', 'Your resume is deleted successfully!!.');
                    return redirect()->route('resume.list');
    }

     public function fetch_state(Request $request)
    {   
        if (!UserAuth::isLogin()) {
            return redirect('/signup');
        }
        // dd($request->all()); 
        $blogs = Resume::find($request->userid);
         // dd($blogs);
        $state = State::where('country_id', $request->id)->get();
        $stateHtml = "";

        foreach ($state as $states) {
          $stateHtml .= "<option " . ($blogs->state == $states["id"] ? 'selected' : '') . " value='" . $states["id"] . "'>" . $states["name"] . "</option>";
        }
        return response()->json(
            [
                'success' => 'Profile image updated.',
                "option_html" => $stateHtml
            ]
        );
    }

    


public function FilterResume(Request $request)
{
    if (!UserAuth::isLogin()) {
        return redirect('/signup');
    }
    // dd($request->all());

    $now = Carbon::now()->subDays($request->datePosted); // Convert to date string
    $resume = Resume::whereBetween('created_at', [$now->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->get();
    // dd($resume);

    $filterData = "";
    foreach ($resume as $Records) {
     $filterData .= '<div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
                    <div class="feature-box">
                        <div data-postid="' . $Records->id . '" data-Userid="" class="save-btn saved_post_btn" title="Save">Save</div>
                        <a href="' . route('resume.single-post', $Records->id) . '">
                            <div id="demo-new" class="">
                                <div class="carousel-inner">
                                    <div class="carousel-item-test">';
                                        // Check if an image is available
                                        if(isset($Records->uploadPicture)){
                                            $filterData .='<img src="' . asset('images_resume_img') . '/' . $Records->uploadPicture . '" alt="Los Angeles" class="d-block w-100">';
                                        }else{
                                            $filterData .='<img src="' . asset('images_blog_img/1688636936.jpg') . '" alt="Los Angeles" class="d-block w-100">';
                                        }
$filterData .= '</div>
                                </div>
                            </div>
                            <p class="job-title">' . $Records->firstName . '</p>
                            <div class="main-days-frame">
                                <span class="location-box">
                                    ' . $Records->phoneNumber . '
                                </span>
                                <span class="days-box">'; 
                                    // Calculate time difference and display it
                                    $givenTime = strtotime($Records->created_at);
                                    $currentTimestamp = time();
                                    $timeDifference = $currentTimestamp - $givenTime;

                                    $days = floor($timeDifference / (60 * 60 * 24));
                                    $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                    $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                    $seconds = $timeDifference % 60;

                                    $timeAgo = "";
                                    if ($days > 0) {
                                        if ($days == 1) {
                                            $timeAgo .= $days . " day ago ";
                                        } else {
                                            $timeAgo .= $days . " days ago ";
                                        }
                                    }else{
                                        $timeAgo .= "Today"; 
                                    }
                                    
                                    // Append timeAgo to the HTML
                                    $filterData .= $timeAgo;
$filterData .= '</span>
                            </div>
                        </a> 
                    </div>
                </div>';

}
 echo $filterData;
     
}




public function Savedpost(Request $request)
{
    if (!UserAuth::isLogin()) {
        return redirect('/signup');
    }
    // Get the user_id and post_id from the request
    $user_id = $request->userid;
    $post_id = $request->post_id;

    // Check if the record already exists
    $existingRecord = DB::table('saved_post')
                        ->where('user_id', $user_id)
                        ->where('post_id', $post_id)
                        ->first();

    if ($existingRecord) {
        // Record already exists, return a message
        return response()->json(['error' => 'You already saved this post.'], 400);
    }

    // If the record doesn't exist, perform the insert
    $data = [
        'user_id' => $user_id,
        'post_id' => $post_id
    ];
    $inst = DB::table('saved_post')->insert($data);
    
    if ($inst) {
        return response()->json(['success' => 'Post saved.' , 'saved' => 'true'], 200);
    } else {
        return response()->json(['error' => 'Something went wrong.'], 400);
    }
}




}
