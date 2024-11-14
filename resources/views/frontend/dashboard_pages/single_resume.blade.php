<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')

<?php 
//echo "<pre>"; print_r($resume); echo "</pre>";
?>
<style>

button.btn.single-resume-button {
	/* background-color: #FCD152; */
	background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%);
    border: 1px solid #dc7228 !important;
	/* width: 130px; */
	height: 40px;
	margin-top: 3px;
	border-radius: 35px;
	border: 0px;
	box-shadow: none;
    font-size: 14px;
	color: #fff !important;
}

</style>
<section id="job-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="bg-white" style="padding: 20px;margin-top: 20px;border-radius: 10px;">
                    <div class="job-post-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="job-post-imges">
                                   <img src="{{asset('images_resume_img')}}/<?php echo $resume['uploadPicture'];?>" alt="<?php echo $resume['uploadPicture'];?>" height="200px">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="job-post-content">
                                    <h2><?php echo $resume['firstName'] . ' ' . $resume['lastName']; ?></h2>
                                    <div class="job-type">
                                        <p><strong>Education Level:</strong> <?php echo $resume['educationLevel']; ?></p>
                                        <p><strong>Field of Study:</strong> <?php echo $resume['fieldOfStudy']; ?></p>
                                         <p><strong>Phone Number:</strong> <?php echo $resume['phoneNumber']; ?></p>
                                        <p><strong>School Name:</strong> <?php echo $resume['schoolName']; ?></p>
                                        <p><strong>Address:</strong> <?php echo $resume['streetAddress']; ?></p>
                                    </div>
                                    <hr>
                                    <div class="job-type">
                                        <!-- Display Other Applicant Information Here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="job-detail pt-2 mt-2">
                            <h4>Job Description</h4>
                            <p><?php echo $resume['coverLetter']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">

                <div>
                    <h2>Resume</h2>
                    <iframe id="pdfViewer" src="{{ asset('images_blog_doc/' . $resume['uploadResume']) }}" frameborder="0" scrolling="auto" width="100%" height="500"></iframe>
                </div>
                
                <!-- Link to open PDF in a new tab -->
                <div>
                <a href="{{asset('images_blog_doc')}}/<?php echo $resume['uploadResume'];?>" target="_blank"> <button class="btn single-resume-button" type="button">Open PDF in New Tab</button></a>
                </div>

            </div>

        </div>
    </div>
</section>


@endsection