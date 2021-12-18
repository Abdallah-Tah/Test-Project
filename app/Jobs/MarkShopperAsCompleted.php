<?php

namespace App\Jobs;

use App\Models\Shopper\Shopper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarkShopperAsCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $shopper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Shopper $shopper)
    {
        $this->shopper = $shopper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->shopper->status_id = 2;
        $this->shopper->save();
    }
}
