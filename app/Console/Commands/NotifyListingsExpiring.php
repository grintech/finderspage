<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Blogs;
use App\Libraries\General;
use App\Models\Admin\Notification;
use App\Models\Admin\Users;
class NotifyListingsExpiring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:listings-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to users about listings that are expiring in a week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $blogs = BlogCategoryRelation::join('blogs', function($join) {
            $join->on('blogs.id', '=', 'blog_category_relation.blog_id')
                 ->on('blogs.sub_category', '=', 'blog_category_relation.sub_category_id');
        })
        ->where('blogs.status', 1)
        ->whereNull('blogs.deleted_at')
        ->where('blogs.draft', 1)
        ->select('blogs.*', 'blog_category_relation.category_id')
        ->get();
        
        foreach($blogs as $blog){
            
                $route = '#';
                $category_name = '';
                if ($blog->category_id == 1) {
                    $category_name = 'Business';
                    $route = route('business_page.front.single.listing', $feature->slug);
                } elseif ($blog->category_id == 2) {
                    $category_name = 'Jobs';
                    $route = route('jobpost', $blog->slug);
                } elseif ($blog->category_id == 4) {
                    $category_name = 'Real Estate';
                    $route = route('real_esate_post', $blog->slug);
                } elseif ($blog->category_id == 5) {
                    $category_name = 'Welcome to our Community';
                    $route = route('community_single_post', $blog->slug);
                } elseif ($blog->category_id == 6) {
                    $category_name = 'Shopping';
                    $route = route('shopping_post_single', $blog->slug);
                } elseif ($blog->category_id == 7) {
                    $category_name = 'Fundraisers';
                    $route = route('single.fundraisers', $blog->slug);
                } elseif ($blog->category_id == 705) {
                    $category_name = 'Services';
                    $route = route('service_single', $blog->slug);
                } elseif ($blog->category_id == 741) {
                    $category_name = 'Entertainment Industry';
                    $route = route('Entertainment.single.listing', $blog->slug);
                }
            $givenTime = strtotime($blog->created);
            $currentTimestamp = time();
            $timeDifference = $currentTimestamp - $givenTime;

            $days = floor($timeDifference / (60 * 60 * 24));
            $slug = $blog->slug;
            if($days == 37){
                $userData = Users::where('id',$blog->user_id)->first();
                $notice = [
                    'from_id' => 7,
                    'to_id' =>$userData->id,
                    'type' => 'post',
                    'message' => 'Your listing expires in 7 days',
                    ];
                Notification::create($notice); 

                $codes = [
                    '{first_name}' => $userData->username,
                    '{listing_link}' => $route,
                ];

                General::sendTemplateEmail(
                    $userData->email,
                    'weekly-notification-before-the-expiration-date',
                    $codes
                );
                
                echo'Notifications sent successfully!';
            }
        }
        
    }
}
