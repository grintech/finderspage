<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\BlogCategoryRelation;
use App\Models\Blogs;
use App\Models\BlogPost;
use App\Models\Entertainment;
use Carbon\Carbon;


class UpdatePostStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update post status if older than 44 days';

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
           $BumpPost = Blogs::where('status', 1)->where('created', '<=', Carbon::now()->subDays(44))->update([
                'normal_end_date' => null,
                'status' =>0,
                'draft' =>0,
                
            ]);
            $Entertainment = Entertainment::where('status', 1)->where('created_at', '<=', Carbon::now()->subDays(44))->update([
                'normal_end_date' => null,
                'status' =>0,
                'draft' =>0,
                
            ]); 

            } catch (QueryException $e) {
                echo'QueryException: ' . $e->getMessage();
                // Handle the query exception, e.g., rollback transactions, notify administrators, etc.
            } catch (\Exception $e) {
                echo'Exception: ' . $e->getMessage();
                // Handle other exceptions as needed
            }
    }
}
