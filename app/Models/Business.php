<?php

namespace App\Models;
use App\Models\BlogCategories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Business extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ="businesses";
    protected $fillable = [
        'user_id',
        'business_name',
        'available_now',
        'available_since',
        'slug',
        'sub_category',
        'add_button',
        'selected_button',
        'selected_button_url',
        'choice',
        'parking',
        'location_of_service',
        'speak_language',
        'holistic_services',
        'state_license_number',
        'contractor_license_number',
        'offers_free_consult',
        'business_email',
        'business_phone',
        'business_website',
        'address_1',
        'address_2',
        'status',
        'country',
        'state',
        'city',
        'zip_code',
        'location',
        'opening_hours',
        'video',
        'gallery_image',
        'business_logo',
        'facebook',
        'youtube',
        'instagram',
        'tiktok',
        'whatsapp',
        'business_description',
        'type',
        'draft',
        'featured',
        'deleted_at',
    ];


    public function create_business_page($request)
    {
         
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];
    
            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/business_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
        }
    
        // Handle business logo
        if ($request->hasFile('business_logo')) {
            $logo = $request->file('business_logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/business_img'), $logoName);
        }
    
        // Handle business video
        if ($request->hasFile('business_video')) {
            $video = $request->file('business_video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('/business_img'), $videoName);
        }
        
        if($request->sub_category == "Other"){
            $getcategory = BlogCategories::where("title", $request->sub_category_oth)->first();
            $sub_category = $getcategory->id;
        }else{
            $sub_category = $request->sub_category;
        }
        // Get logged-in user
        $user = UserAuth::getloginuser();
        $slug = $this->slugify($request->business_name,$divider = '-');
        // Insert business data and return the inserted business ID
        
        if($request->selected_button == "order_online"){
            $selected_button_url = implode(",",$request->order_online);
        }elseif($request->selected_button == "book"){
            $selected_button_url = implode(",",$request->book);
        }elseif($request->selected_button == "purchase"){
            $selected_button_url = implode(",",$request->purchase);
        }elseif($request->selected_button == "learn_more"){
            $selected_button_url = implode(",",$request->learn_more);
        }elseif($request->selected_button == "order_food"){
            $selected_button_url = implode(",",$request->order_food);
        }elseif($request->selected_button == "reserve"){
            $selected_button_url = implode(",",$request->reserve);
        }elseif($request->selected_button == "gift_cards"){
            $selected_button_url = implode(",",$request->gift_cards);
        }elseif($request->selected_button == "contact_us"){
            $selected_button_url = implode(",",$request->contact_us);
        }elseif($request->selected_button == "shop_now"){
            $selected_button_url = implode(",",$request->shop_now);
        }elseif($request->selected_button == "watch_video"){
            $selected_button_url = implode(",",$request->watch_video);
        }elseif($request->selected_button == "sign_up"){
            $selected_button_url = implode(",",$request->sign_up);
        }elseif($request->selected_button == "send_email"){
            $selected_button_url = implode(",",$request->send_email);
        }elseif($request->selected_button == "whats_app"){
            $selected_button_url = implode(",",$request->whats_app);
        }elseif($request->selected_button == "follow"){
            $selected_button_url = implode(",",$request->follow);
        }elseif($request->selected_button == "start_order"){
            $selected_button_url = implode(",",$request->start_order);
        }elseif($request->selected_button == "join"){
            $selected_button_url = implode(",",$request->join);
        }


        $business = Self::create([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'sub_category' => isset($sub_category) ? implode(",", $sub_category) : null,
            'add_button' => $request->add_button ?? null,
            'selected_button' => $request->selected_button ?? null,
            'selected_button_url' => $selected_button_url ?? null,
            'choice' => isset($request->choices) ? implode(',', $request->choices) : null,
            'parking' => isset($request->parking) ?implode(',', $request->parking) : null,
            'location_of_service' => isset($request->location_of_service) ? $request->location_of_service : null,
            'speak_language' => isset($request->speak_language) ?implode(',', $request->speak_language) : null,
            'holistic_services' => isset($request->holistic_services) ? $request->holistic_services : null,
            'state_license_number' => isset($request->state_license_number) ? $request->state_license_number : null,
            'contractor_license_number' => isset($request->contractor_license_number) ? $request->contractor_license_number : null,
            'offers_free_consult' => isset($request->offers_free_consult) ? $request->offers_free_consult : null,
            'business_email' => $request->business_email ?? null,
            'business_phone' => $request->business_phone ?? null,
            'business_website' => $request->business_website ?? null,
            'address_1' => implode(",",$request->address_1) ?? null,
            'address_2' => implode(",",$request->address_2) ?? null,
            'country' => implode(",",$request->country) ?? null,
            'state' => implode(",",$request->state) ?? null,
            'city' => implode(",",$request->city) ?? null,
            'zip_code' => implode(",",$request->zip_code) ?? null,
            'location' => implode(",",$request->location) ?? null,
            'opening_hours' => isset($request->opening_hours) ? implode(',', $request->opening_hours) : null,
            'video' => $videoName ?? null,
            'gallery_image' => !empty($imageNames) ? json_encode($imageNames) : null,
            'business_logo' => $logoName ?? null,
            'facebook' => $request->facebook ?? null,
            'instagram' => $request->instagram ?? null,
            'tiktok' => $request->tiktok ?? null,
            'youtube' => $request->youtube ?? null,
            'whatsapp' => $request->whatsapp ?? null,
            'status' => 0,
            'draft' => '1',
            'slug' => $slug,
            'business_description' => $request->business_description,
        ]);
    
        // Return the ID of the inserted business
        return $business;
    }



    public function update_business_page($request,$id)
    {
        //   dd($request->all());
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $imageNames = [];
    
            foreach ($images as $image) {
                $name = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('/business_img');
                $image->move($destinationPath, $name);
                $imageNames[] = $name;
            }
            // Convert imageNames array to JSON if needed
            $imageNamesJson = json_encode($imageNames);
        }else{
            $imageNamesJson = $this->gallery_image;  // Assign default gallery image to array
            
        }
    
        // Handle business logo
        if ($request->hasFile('business_logo')) {
            $logo = $request->file('business_logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/business_img'), $logoName);
        }else{
            $logoName = $this->business_logo;
        }
        
    
        // Handle business video
        if ($request->hasFile('business_video')) {
            $video = $request->file('business_video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('/business_img'), $videoName);
        }else{
            $videoName = $this->video;
        }

        if($request->sub_category == "Other"){
            $getcategory = BlogCategories::where("title", $request->sub_category_oth)->first();
            $sub_category = $getcategory->id;
        }else{
            $sub_category = $request->sub_category;
        }


        if($request->selected_button == "order_online"){
            $selected_button_url = implode(",",$request->order_online);
        }elseif($request->selected_button == "book"){
            $selected_button_url = implode(",",$request->book);
        }elseif($request->selected_button == "purchase"){
            $selected_button_url = implode(",",$request->purchase);
        }elseif($request->selected_button == "learn_more"){
            $selected_button_url = implode(",",$request->learn_more);
        }elseif($request->selected_button == "order_food"){
            $selected_button_url = implode(",",$request->order_food);
        }elseif($request->selected_button == "reserve"){
            $selected_button_url = implode(",",$request->reserve);
        }elseif($request->selected_button == "gift_cards"){
            $selected_button_url = implode(",",$request->gift_cards);
        }elseif($request->selected_button == "contact_us"){
            $selected_button_url = implode(",",$request->contact_us);
        }elseif($request->selected_button == "shop_now"){
            $selected_button_url = implode(",",$request->shop_now);
        }elseif($request->selected_button == "watch_video"){
            $selected_button_url = implode(",",$request->watch_video);
        }elseif($request->selected_button == "sign_up"){
            $selected_button_url = implode(",",$request->sign_up);
        }elseif($request->selected_button == "send_email"){
            $selected_button_url = implode(",",$request->send_email);
        }elseif($request->selected_button == "whats_app"){
            $selected_button_url = implode(",",$request->whats_app);
        }elseif($request->selected_button == "follow"){
            $selected_button_url = implode(",",$request->follow);
        }elseif($request->selected_button == "start_order"){
            $selected_button_url = implode(",",$request->start_order);
        }elseif($request->selected_button == "join"){
            $selected_button_url = implode(",",$request->join);
        }
        // dd($sub_category);
    
        // Get logged-in user
        $user = UserAuth::getloginuser();
        // Insert business data and return the inserted business ID
        $this->update([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'sub_category' => isset($sub_category) ? implode(",", $sub_category) : null,
            'add_button' => $request->add_button ?? $this->add_button,
            'selected_button' => $request->selected_button ?? $this->selected_button,
            'selected_button_url' =>  $selected_button_url ?? $this->selected_button_url,
            'choice' => isset($request->choices) ? implode(',', $request->choices) : null,
            'parking' => isset($request->parking) ?implode(',', $request->parking)  : null,
            'location_of_service' => isset($request->location_of_service) ? $request->location_of_service : null,
            'speak_language' => isset($request->speak_language) ?implode(',', $request->speak_language) : null,
            'holistic_services' => isset($request->holistic_services) ? $request->holistic_services : null,
            'state_license_number' => isset($request->state_license_number) ? $request->state_license_number : null,
            'contractor_license_number' => isset($request->contractor_license_number) ? $request->contractor_license_number : null,
            'offers_free_consult' => isset($request->offers_free_consult) ? $request->offers_free_consult : null,
            'business_email' => $request->business_email ?? null,
            'business_phone' => $request->business_phone ?? null,
            'business_website' => $request->business_website ?? null,
            'address_1' => implode(",",$request->address_1) ?? null,
            'address_2' => implode(",",$request->address_2) ?? null,
            'country' => implode(",",$request->country) ?? null,
            'state' => implode(",",$request->state) ?? null,
            'city' => implode(",",$request->city) ?? null,
            'zip_code' => implode(",",$request->zip_code) ?? null,
            'location' => implode(",",$request->location) ?? null,
            'opening_hours' => isset($request->opening_hours) ? implode(',', $request->opening_hours) : null,
            'video' => $videoName ?? null,
            'gallery_image' => $imageNamesJson ?? null, // Ensure $imageNamesJson is properly JSON encoded beforehand
            'business_logo' => $logoName ?? null,
            'facebook' => $request->facebook ?? null,
            'instagram' => $request->instagram ?? null,
            'tiktok' => $request->tiktok ?? null,
            'youtube' => $request->youtube ?? null,
            'whatsapp' => $request->whatsapp ?? null,
            'draft' => '1',
            'business_description' => $request->business_description,
        ]);
        return $this;
    }



    public static function slugify($text, string $divider = '-', int $randomLength = 4)
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            $text = 'n-a';
        }

        // add random string at the end
        $randomString = substr(md5(uniqid(rand(), true)), 0, $randomLength);
        $text .= $divider . $randomString;

        return $text;
    }

    public static function getCategory($ids = [])
{
    // Check if the $ids array is not empty
    if (!empty($ids)) {
        // Fetch only the 'title' field for categories with the specified IDs
        $category = BlogCategories::whereIn('id', $ids)->pluck('title')->toArray();

        // Check if $category is not empty before using implode
        if (!empty($category)) {
            $encode = implode(', ', $category);
            // dd($encode);
            return $encode;
        }

        // Return an empty string or handle the case when no titles are found
        return '';
    }

    return ''; // If $ids is empty, return an empty string or handle as needed
}


}
