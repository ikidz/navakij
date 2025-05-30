<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SellAgentBulks;
use App\Jobs\ImportSellAgentsJob;

class ImportSellAgentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sellagent';

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
        $pendings = SellAgentBulks::Pending()->orderBy('created_at','desc')->limit(1);
        if( $pendings->count() <= 0 ){
            return 0;
        }else{
            $pending = $pendings->first();
            $this->info('Import : '.$pending->name);
            ImportSellAgentsJob::dispatch( $pending );
        }
    }
}
