<?php

namespace App\Console\Commands;

use App\Jobs\ProceedPrizeJob;
use App\Models\Prize;
use Illuminate\Console\Command;

class ProceedPrizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prizes:proceed {count?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обрабатывает призы';

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
        $count = $this->argument('count') ?: 20;
        $prizes = Prize::query()->where('status', 'draft')->where('created_at', '<', now()->addSeconds(-60))->limit($count)->get();
        foreach ($prizes as $prize) {
            ProceedPrizeJob::dispatch($prize);
        }
        $this->comment("Нашёл призов {$prizes->count()} при лимите {$count}");
        return 0;
    }
}
