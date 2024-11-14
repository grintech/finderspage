<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Console\Command;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Entertainment;
use App\Models\Admin\Users;
use Carbon\Carbon;

class UpdateListings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update outdated listing';

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
       

try {
    $currentDateTime = Carbon::now();

    // Feature End Date
    $userIdsFeature = Users::where('feature_end_date', '<', $currentDateTime)
        ->pluck('id');
    $usersFeature = Users::where('feature_end_date', '<', $currentDateTime)->update([
        'feature_start_date' => '',
        'feature_end_date' => '',
    ]);

    foreach ($userIdsFeature as $userId_feature) {
        $FeaturePost = Blogs::where('user_id', '=', $userId_feature)->update([
            'featured_post' => null,
        ]);
    }

    
        $BumpPost_blogs = Blogs::where('bump_end', '<', $currentDateTime)->update([
            'bumpPost' => 0,
            'bump_start' => null,
            'bump_end' => null,
            'normal_post' => '1',
        ]);

        $BumpPost_blogPost = BlogPost::where('bump_end', '<', $currentDateTime)->update([
            'bumpPost' => '0',
            'bump_start' => null,
            'bump_end' => null,
            'normal_post' => '1',
        ]);

        $BumpPost_Entertainment = Entertainment::where('bump_end', '<', $currentDateTime)->update([
            'bumpPost' => 0,
            'bump_start' => null,
            'bump_end' => null,
            'normal_post' => '1',
        ]);


        $BumpPost_Video = Video::where('bump_end', '<', $currentDateTime)->update([
            'bumpPost' => 0,
            'bump_start' => null,
            'bump_end' => null,
            'normal_post' => '1',
        ]);
    
        
    
       echo'Cron run successfully.';
    
} catch (QueryException $e) {
    Log::error('QueryException: ' . $e->getMessage());
    // Handle the query exception, e.g., rollback transactions, notify administrators, etc.
} catch (\Exception $e) {
    Log::error('Exception: ' . $e->getMessage());
    // Handle other exceptions as needed
}

    }
}
