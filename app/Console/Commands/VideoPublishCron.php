<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Video;

class VideoPublishCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'VideoPublish:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // \Log::info('Cron run successfully..!');
         $currentDateTime = Carbon::now();
           
               $vidCron = Video::where('schedule', '<', $currentDateTime)->update([
                    'status' => '1',
                    // Add other columns you want to update here.
                ]);

            if($vidCron){
                 \Log::info('Cron run successfully..!');
            }else{
                \Log::info('somthing went Wrong/......');
            }
       
    }
}
