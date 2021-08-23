<?php

namespace App\Jobs;

use App\Models\Prize;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProceedPrizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Prize $prize)
    {
        $this->prize = $prize;
        $this->onQueue('proceed_prize');
    }

    private $prize;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->prize->proceed();
    }
}
