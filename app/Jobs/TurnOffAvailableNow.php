<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Blogs;
use Carbon\Carbon;

class TurnOffAvailableNow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $blog; // Define the $blog property

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Blogs $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    
    public function handle()
    {
        $blog = Blogs::find($this->blog->id);

        // Check if 60 minutes have passed since they became available
        if ($blog && $blog->available_since) {
            // Convert the available_since string to a Carbon instance
            $availableSince = Carbon::parse($blog->available_since);

            // Check if 60 minutes have passed
            if ($availableSince->diffInMinutes(now()) >= 1) {
                $blog->available_now = 0;
                $blog->available_since = null;
                $blog->save();
            }
        }
    }
}
