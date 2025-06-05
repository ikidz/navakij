<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportBranchJob;
use App\Models\BranchBulk;
use App\Console\Commands\ImportBranchCommand;
class ImportBranchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:branch';

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
        $pending = BranchBulk::Pending()->orderBy("bulk_createdtime","ASC")->limit(1);
        if($pending->count()==0){
            return 0;
        }else{
            $job = $pending->first();
            $this->info("Importing ".$job->bulk_title);
            ImportBranchJob::dispatch($job);
        }

        return 0;
    }
}
