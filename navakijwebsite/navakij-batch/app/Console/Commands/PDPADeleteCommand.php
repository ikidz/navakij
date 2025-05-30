<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PDPADeleteJob;

class PDPADeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdpa:delete_old_data';

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
        PDPADeleteJob::dispatch();
        return 0;
    }
}
