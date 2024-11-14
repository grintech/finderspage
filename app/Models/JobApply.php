<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;

class JobApply extends Model
{
    use HasFactory;
    protected $table ="jobapply";
    protected $fillable=[
                            "job_id",
                            "applicant_id",
                            "first_name",
                            "last_name",
                            "email",
                            "phone_no",
                            "file",
                            "type",
                            "image",
                            "video",
                            "cover_letter"
                        ];


    public static function applyJob($request){

            if ($request->hasFile('file')) {
                $file = $request->file;
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('File_jobApply'), $fileName);
            }
            if ($request->hasFile('image')) {
                $images = $request->file('image'); // Get the array of images
                foreach ($images as $file) {
                    $fileName_image = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('File_jobApply'), $fileName_image);
                }
            }

            if ($request->hasFile('video')) {
                $file_video = $request->video;
                $fileName_video = time() . '.' . $file->getClientOriginalExtension();
                $file_video->move(public_path('File_jobApply'), $fileName_video);
            }
            $applicant_id = UserAuth::getLoginId();
            self::create([
                            'job_id' => $request->job_id, 
                            'applicant_id' => $applicant_id, 
                            'first_name' => $request->first_name, 
                            'last_name' => $request->last_name, 
                            'email' => $request->email, 
                            'phone_no' => $request->phone_no, 
                            'file' => $fileName, 
                            'image' => $fileName_image, 
                            'video' => $fileName_video, 
                            'type' => $request->type, 
                            'cover_letter' => $request->cover_letter, 
                        ]);
        }



    public static function applyJob_update($request,$id){

         if ($request->hasFile('file')) {
                $file = $request->file;
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('File_jobApply'), $fileName);
            }else{
                $fileName = $this->file;
            }
            if ($request->hasFile('image')) {
                $images = $request->file('image'); // Get the array of images
                foreach ($images as $file) {
                    $fileName_image = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('File_jobApply'), $fileName_image);
                }
            }else{
                $fileName_image = $this->image;
            }

            if ($request->hasFile('video')) {
                $file_video = $request->video;
                $fileName_video = time() . '.' . $file->getClientOriginalExtension();
                $file_video->move(public_path('File_jobApply'), $fileName_video);
            }else{
                $fileName_video = $this->video;
            }

        $applicant_id = UserAuth::getLoginId();
        $this->update([
                        'job_id' => $request->job_id, 
                        'applicant_id' => $applicant_id, 
                        'first_name' => $request->first_name, 
                        'last_name' => $request->last_name, 
                        'email' => $request->email, 
                        'phone_no' => $request->phone_no, 
                        'file' => $fileName, 
                        'image' => $fileName_image, 
                        'video' => $fileName_video, 
                        'type' => $type, 
                        'cover_letter' => $request->cover_letter, 
                    ]);
    }



    public static function get_on_of_applicant($job_id){
      $applicant = JobApply::where('job_id',$job_id)->count(); 
      return  $applicant;
    }

    public static function get_Data_of_applicant($job_id){
        $applicant = JobApply::where('job_id',$job_id)->get(); 
        return  $applicant;
    }
}
