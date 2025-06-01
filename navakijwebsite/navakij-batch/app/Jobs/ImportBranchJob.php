<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\BranchBulk;
use App\Models\Branch;
use App\Models\Province;
use App\Models\District;
use App\Models\Subdistrict;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportBranchExport;
class ImportBranchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $model;
    public $failOnTimeout = true;
    public function __construct(BranchBulk $model)
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
        if(trim($this->model->bulk_file)==null){
            $this->status('error','No uploaded file.');
            // $this->fail();
            return 0;
        }

        // dd( is_file( realpath( env('CI_ROOTPATH').'/branch_bulks/'.$this->model->bulk_file ) ) );
        if(\Storage::disk('ci_local')->exists('branch_bulks/'.$this->model->bulk_file) === false){
        // if( is_file( realpath( env('CI_ROOTPATH').'/branch_bulks/'.$this->model->bulk_file ) ) === false ){
            $this->status('error','File "'.$this->model->bulk_file.'" is not exists.');
            // $this->fail();
            return 0;
        }
        $file = \Storage::disk('ci_local')->get('branch_bulks/'.$this->model->bulk_file);
        \Storage::disk('local')->put('branch_bulks/'.$this->model->bulk_file,$file);
        $localfile = \Storage::disk('local')->path('branch_bulks/'.$this->model->bulk_file);

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

        // $this->status('processing');

        try{
            $model = $this->model;
            $results = DB::transaction(function () use($model,$datas) {
                $out = new \Symfony\Component\Console\Output\ConsoleOutput();

								/* Provinces, districts and subdistricts - Start */
				        $provinces = Province::where('is_actived', 'Y')->get()->pluck( 'name', 'province_id')->toArray();
				        $districts = District::where('is_actived', 'Y')->get()->pluck( 'name', 'amphoe_id')->toArray();
				        $subdistricts = Subdistrict::where('is_actived', 'Y')->get()->pluck( 'name', 'tambon_id')->toArray();
				        /* Provinces, districts and subdistricts - End */

                $errors = [];
                $success = [];

                if(Branch::count() > 0){
                    $branch_order = Branch::orderBy('branch_order','desc')->limit(1)->first()->branch_order;
                }else{
                    $branch_order = 1;
                }

                /* Truncate `branches` - Start */
                Branch::where([
                    'category_id' => $model->category_id
                ])->update([
                    'branch_status' => 'discard',
                ]);
                /* Truncate `branches` - End */

                foreach($datas as $row){
                    if(app()->runningInConsole()){
                        $out->writeln($row['ชื่อ (ไทย)'].' Brand : '.$row['แบรนด์']);
                    }
                    if($row['ชื่อ (En)']==""){
                        $row['ชื่อ (En)'] = $row['ชื่อ (ไทย)'];
                    }
                    // $branch_th = Branch::where("branch_title_th",$row['ชื่อ (ไทย)']);
                    // $province = Province::where("name",$row['จังหวัด']);
                    $province = array_search($row['จังหวัด'], $provinces);

                    // if($branch_th->count() > 0){
                    //     $row['reason'] = "ชื่อภาษาไทย มีในระบบแล้ว";
                    //     $errors[] = $row;
                    //     continue;
                    // }
                    if(!$province){
                        $row['reason'] = "จังหวัด ไม่ถูกต้อง";
                        $errors[] = $row;
                        continue;
                    }
                    $province_id = $province;
                    if( $row['อำเภอ/เขต'] != '' ){
                        // $district = District::where('province_id',$province_id)->where("name",$row['อำเภอ/เขต']);
												$district = array_search($row['อำเภอ/เขต'], $districts);
                        if(!$district){
                            $row['reason'] = "อำเภอ/เขต ไม่ถูกต้อง";
                            $errors[] = $row;
                            continue;
                        }
                        $district_id = $district;
                    }else{
                        $district_id = 0;
                    }
                    if( $row['ตำบล/แขวง'] != '' ){
                        // $subdistrict = Subdistrict::where('amphoe_id',$district_id)->where("name",$row['ตำบล/แขวง']);
												$subdistrict = array_search($row['ตำบล/แขวง'], $subdistricts);
                        if(!$subdistrict){
                            $row['reason'] = "ตำบล/แขวง ไม่ถูกต้อง";
                            $errors[] = $row;
                            continue;
                        }
                        $subdistrict_id = $subdistrict;
                    }else{
                        $subdistrict_id = 0;
                    }

                    Branch::create([
                        "category_id" => $model->category_id,
                        // "branch_image",
                        "branch_title_th" => $row["ชื่อ (ไทย)"],
                        "branch_title_en" => $row["ชื่อ (En)"],
                        "branch_tel" => $row["เบอร์โทรศัพท์"],
                        "branch_fax" => $row["เบอร์แฟ็กซ์"],
                        "branch_email" => $row["อีเมล"],
                        "branch_website" => $row["เว็บไซต์"],
                        "branch_address" => $row["ที่อยู่"],
                        // "is_partner" => $row[""],
                        // "branch_lat" => (float) $row["Latitute"],
                        // "branch_lng" => (float) $row["Longitude"],
                        "branch_gmap_url" => ( $row["Google Map"] == "-" || !$row["Google Map"] ? null : $row["Google Map"] ),
                        "province_id" => $province_id,
                        "district_id" => $district_id,
                        "subdistrict_id" => $subdistrict_id,
                        "card" => $row['บัตร'],
                        "patient_department" => $row['IPD/OPD'],
                        "brands" => strtolower( $row['แบรนด์'] ) ?? null,
                        "branch_order" => $branch_order,
                        "is_on_website" => intval( $row["แสดงผลบนเว็บไซต์"] ),
                        "is_on_pdf" => intval( $row["แสดงผลบน PDF"] ),
                        "branch_status" => "approved"
                    ]);
                    $success[] = $row;
                    $branch_order++;
                }
                return [
                    'errors' => $errors,
                    'success' => $success
                ];
            });

            \Excel::store(new ReportBranchExport($results), 'branch_bulks/'.$report_file, config("filesystems.default"));
            $this->finish($results,$report_file);

        } catch (Exception $e) {
            \Log::debug( $e->getMessage() );
        }


    }

    // public function failed(Throwable $exception)
    // {
    //     $this->status('error',$exception->getMessage());
    // }


    private function status($status,$message=NULL){
        $this->model->update([
            'bulk_process_time' => now()->format('Y-m-d H:i:s'),
            'bulk_remark' => $message,
            'bulk_status' => $status,
        ]);
    }
    private function finish($results,$report_file){
        if(count($results['errors']) > 0){
            $this->model->update([
                'bulk_finished_time' => now()->format('Y-m-d H:i:s'),
                'bulk_remark' => 'นำเข้าข้อมูลสำเร็จบางส่วน',
                'bulk_status' => 'patial_finished',
                'bulk_report' => $report_file
            ]);
        }else{
            $this->model->update([
                'bulk_finished_time' => now()->format('Y-m-d H:i:s'),
                'bulk_remark' => 'นำเข้าข้อมูลสำเร็จ',
                'bulk_status' => 'finished',
                'bulk_report' => $report_file
            ]);
        }

    }
}
