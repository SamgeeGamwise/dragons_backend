<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Campaign;


class SyncFirebase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $campaign_id;
    private $reference;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id, $reference)
    {
        $this->campaign_id = $campaign_id;
        $this->reference = $reference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Campaign::whereId($this->campaign_id)->update([
            'firebase_key' => app('firebase.database')->getReference($this->reference)->push()->getKey(),
        ]);
    }
}
