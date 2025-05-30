<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SellAgentBulks;
use App\Models\SellAgents;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportSellAgentsExport;

class ImportSellAgentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $model;
    public $failOnTimeout = true;
    public function __construct(SellAgentBulks $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(trim($this->model->file)==null){
            $this->status('failed','No uploaded file.');
            // $this->fail();
            return 0;
        }

        if(\Storage::disk('ci_local')->exists('sellagent_bulks/'.$this->model->file)==false){
            $this->status('failed','File "'.$this->model->file.'" is not exists.');
            // $this->fail();
            return 0;
        }

        $file = \Storage::disk('ci_local')->get('sellagent_bulks/'.$this->model->file);
        \Storage::disk('local')->put('sellagent_bulks/'.$this->model->file,$file);
        $localfile = \Storage::disk('local')->path('sellagent_bulks/'.$this->model->file);

        $datass = \Excel::toCollection(collect([]), $localfile);
        $heading = $datass[0][0];
        unset($datass[0][0]);
        $datas = $datass[0]->map(function($row) use($heading){
            $res = [];
            foreach($heading as $idx=>$d){
                $res[trim($d)] = trim($row[$idx]);
            }
            return $res;
        });
        $results = [
            'errors' => [],
            'success' => []
        ];
        $report_file = 'report_'.now()->format('YmdHis').'.xlsx';

        $this->status('processing');

        try{
            $model = $this->model;
            $results = DB::transaction(function () use($model,$datas) {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();

                $errors = [];
                $success = [];

                /* Truncate `sell_agents` - Start */
                SellAgents::whereIn('agent_status', ['approved','pending'])->update([
                    'agent_status' => 'discard'
                ]);
                /* Truncate `sell_agents` - End */

                foreach($datas as $row){
                    if(app()->runningInConsole()){
                        $out->writeln($row['Name']);
                    }

                    SellAgents::create([
                        'agent_name_th' => $row['Name'],
                        'agent_name_en' => $row['Name'],
                        'agent_license_no' => $row['License No.'],
                        'agent_status' => 'approved'
                    ]);

                    $success[] = $row;
                }
                return [
                    'errors' => $errors,
                    'success' => $success
                ];
            });

            \Excel::store(new ReportSellAgentsExport($results), 'sellagent_bulks/'.$report_file, config("filesystems.default"));
            $this->finish($results,$report_file);
        } catch (Exception $e) {
            \Log::debug( $e->getMessage() );
        }
    }

    // public function failed(Throwable $exception)
    // {
    //     $this->status('failed',$exception->getMessage());
    // }


    private function status($status,$message=NULL){
        $this->model->update([
            'process_time' => now()->format('Y-m-d H:i:s'),
            'remark' => $message,
            'status' => $status,
        ]);
    }
    private function finish($results,$report_file){
        if(count($results['errors']) > 0){
            $this->model->update([
                'finished_time' => now()->format('Y-m-d H:i:s'),
                'remark' => 'นำเข้าข้อมูลสำเร็จบางส่วน',
                'status' => 'patial_finished',
                'report' => $report_file
            ]);
        }else{
            $this->model->update([
                'finished_time' => now()->format('Y-m-d H:i:s'),
                'remark' => 'นำเข้าข้อมูลสำเร็จ',
                'status' => 'finished',
                'report' => $report_file
            ]);
        }

    }
}
