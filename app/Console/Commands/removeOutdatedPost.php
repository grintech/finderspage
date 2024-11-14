<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Entertainment;
use Carbon\Carbon;

class removeOutdatedPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:removepost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing post after 44 days';

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
            $BumpPost_normal = Blogs::where('status', 1)
                                    ->where('normal_end_date', '<', $currentDateTime)
                                    ->update([
                                        'normal_end_date' => null,
                                        'featured_post' => null,
                                        'bumpPost' =>0,
                                        'status' =>0,
                                        'draft' =>0,
                                    ]);

            // $video_normal = Video::where('status', 1)->where('normal_end_date', '<', $currentDateTime)->update([
            //     'normal_end_date' => null,
            //     'status' => 0,
            //     'draft' =>0,
            // ]);


            $Entertainment_normal = Entertainment::where('status', 1)->where('normal_end_date', '<', $currentDateTime)->update([
                'normal_end_date' => null,
                'featured_post' => null,
                'bumpPost' =>0,
                'status' =>0,
                'draft' =>0,
                
            ]); 

            // $BlogPost_normal = BlogPost::where('status', 1)->where('normal_end_date', '<', $currentDateTime)->update([
            //     'normal_end_date' => null,
            //     'status' =>0,
            //     'draft' =>0,
                
            // ]);

            } catch (QueryException $e) {
                echo'QueryException: ' . $e->getMessage();
                // Handle the query exception, e.g., rollback transactions, notify administrators, etc.
            } catch (\Exception $e) {
                echo'Exception: ' . $e->getMessage();
                // Handle other exceptions as needed
            }
            
    }
}
