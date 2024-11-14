<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserAuth;
use Auth;

class Resume extends Model
{
    use HasFactory;
    protected $table = "resume";
    protected $fillable = [
                            'user_id', 
                            'firstName', 
                            'lastName',
                            'phoneNumber',
                            // 'streetAddress',
                            'city',
                            'state',
                            'country',
                            'educationLevel',
                            'fieldOfStudy',
                            'schoolName',
                            'uploadPicture',
                            'resumeType',
                            'uploadResume',
                            'timePeriod',
                            'coverLetter',
                            'upload_cover_letter',
                            ];



    public function createResume($request){
        // dd($request->all());
         if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_resume_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        }else{

            $imageNames[] = asset('images/download123.jpg');
        }

        if ($request->hasFile('uploadResume')) {
            $document = $request->file('uploadResume');
            $documentNames = [];

            foreach ($document as $doc) {
                $name = time() . '_' . $doc->getClientOriginalName();
                $destinationPath = public_path('/images_blog_doc');
                $doc->move($destinationPath, $name);
                $documentNames[] = $name;
            }

            
        }else{

            $documentNames[] = null;
        }


        if ($request->hasFile('upload_cover_letter')) {
            $upload_cover = $request->file('upload_cover_letter');
            $upload_coverName = time() . '.' . $logo->getClientOriginalExtension();
            $upload_cover->move(public_path('/images_blog_doc'), $upload_coverName);
        }else{

            $upload_coverName = null;
        }


        self::create([
                    'user_id' =>  UserAuth::getLoginId(),
                    'firstName' =>  $request->firstName,
                    'lastName' =>  $request->lastName,
                    'phoneNumber' =>  $request->phoneNumber,
                    // 'streetAddress' =>  isset($request->streetAddress) ? $request->streetAddress : null,
                    'city' =>  $request->city,
                    'state' =>  $request->state,
                    'country' =>  $request->country,
                    'educationLevel' =>  $request->educationLevel,
                    'fieldOfStudy' =>  $request->fieldOfStudy,
                    'schoolName' =>  $request->schoolName,
                    'uploadPicture' => implode(',',  $imageNames),
                    'uploadResume' =>  implode(',',  $documentNames),
                    'timePeriod' =>  $request->timePeriod,
                    'coverLetter' =>  $request->coverLetter,
                    'upload_cover_letter' =>  $upload_coverName,
                    ]);



    }



    public function UpdateResume($request , $id){
        // dd($request->all());
         if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];

            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/images_resume_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        }else{

            $imageNames[] = $this->uploadPicture;;
        }

        if ($request->hasFile('uploadResume')) {
            $document = $request->file('uploadResume');
            $documentNames = [];

            foreach ($document as $doc) {
                $name = time() . '_' . $doc->getClientOriginalName();
                $destinationPath = public_path('/images_blog_doc');
                $doc->move($destinationPath, $name);
                $documentNames[] = $name;
            }

            
        }else{

            $documentNames[] = $this->uploadResume;
        }



        if ($request->hasFile('upload_cover_letter')) {
            $upload_cover = $request->file('upload_cover_letter');
            $upload_coverName = time() . '.' . $logo->getClientOriginalExtension();
            $upload_cover->move(public_path('/images_blog_doc'), $upload_coverName);
        }else{

            $upload_coverName = $this->upload_cover_letter;
        }


        $this->update([
                    'user_id' =>  UserAuth::getLoginId(),
                    'firstName' =>  $request->firstName,
                    'lastName' =>  $request->lastName,
                    'phoneNumber' =>  $request->phoneNumber,
                    // 'streetAddress' =>  isset($request->streetAddress) ? $request->streetAddress : null,
                    'city' =>  $request->city,
                    'state' =>  $request->state,
                    'country' =>  $request->country,
                    'educationLevel' =>  $request->educationLevel,
                    'fieldOfStudy' =>  $request->fieldOfStudy,
                    'schoolName' =>  $request->schoolName,
                    'uploadPicture' => implode(',',  $imageNames),
                    'uploadResume' =>  implode(',',  $documentNames),
                    'timePeriod' =>  $request->timePeriod,
                    'coverLetter' =>  $request->coverLetter,
                    'upload_cover_letter' =>  $upload_coverName,
                    ]);
    }

}
