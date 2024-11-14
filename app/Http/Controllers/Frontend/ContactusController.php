<?php



namespace App\Http\Controllers\Frontend;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\View;

use App\Libraries\General;

use App\Libraries\FileSystem;

use App\Models\BlogCategories;

use App\Models\Blogs;

use App\Models\BlogCategoryRelation;

use App\Models\UserEnquiry;

use App\Models\Admin\Users;

use Symfony\Component\HttpFoundation\Response;

use Auth;

use App\Models\UserAuth;

use Illuminate\Validation\Rule;

use Illuminate\Support\Arr;

use App\Models\Admin\Settings;



class ContactusController extends Controller

{

    public function index(Request $request, $post_id){

        return view("frontend.contact_us.index",['post_id' => $post_id]);

    }





    public function sendEnquiry(Request $request)
{
    $validator = Validator::make(
        $request->toArray(),
        [
            'g-recaptcha-response' => 'required|captcha',
        ]
    );

    if (!$validator->fails()) {
        $file = null;
        $attachments = array();

        if ($request->file('file') && $request->file('file')->isValid()) {
            $data['path'] = isset($data['path']) && $data['path'] ? $data['path'] : 'tmp';
            $file = FileSystem::uploadFile($request->file('file'), $data['path']);
        }

        if ($file) {
            $attachments[] = $file;
        }

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $description = $request->description;
        $links = $request->links;

        $codes = [
            '{name}' => $name,
            '{enquiry_content}' => $description,
            '{user_name}' => $name,
            '{user_email}' => $email,
            '{user_phone}' => $phone,
            '{user_links}' => $links,
        ];

        General::sendTemplateEmail(
            $email,
            'user-enquiry',
            $codes,
            $attachments,
        );
        General::sendTemplateEmail(
            "wasim.grintech@yopmail.com",
            'user-Enquiry-admin',
            $codes,
            $attachments,
        );

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('contact_file'), $fileName);
        }else{
            $fileName = null;
        }

        $UserEnquiry = new UserEnquiry();
        $UserEnquiry->user_name = $name;
        $UserEnquiry->user_email = $email;
        $UserEnquiry->user_phone = $phone;
        $UserEnquiry->user_enquiry = $description;
        $UserEnquiry->user_file = $fileName;
        $UserEnquiry->links = $links;
        $UserEnquiry->save();

        $request->session()->flash('success', 'Your enquiry has been sent successfully to admin.');
        return redirect()->back();
    } else {
        $request->session()->flash('error', 'Please provide valid inputs.');
        return redirect()->back()->withErrors($validator)->withInput();
    }
}


}