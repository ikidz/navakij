<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Applicants;
use App\Models\SystemSetting;
use App\Models\DeletedData;
use Carbon\Carbon;

class PDPADeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $period = SystemSetting::where([
            'setting_key' => 'pdpa_clearing_range'
        ])->first();

        $targetDate = Carbon::now()->subDays( $period->setting_value );

        $applicants = Applicants::with([
            'addresses' => function( $query ){
                return $query->where('address_type', 'current');
            }
        ])->where('applicant_createdtime','<', $targetDate);
        
        // dd( $targetDate );
        // dd( $applicants->count() );

        if( $applicants->count() > 0 ){
            foreach( $applicants->get() as $applicant ){

                // dd( $applicant );
                /* Save delete logs - Start */
                DeletedData::insert([
                    'deleted_name' => $applicant->applicant_fname_th.' '.$applicant->applicant_lname_th,
                    'deleted_idcard' => $applicant->applicant_idcard,
                    'deleted_tel' => $applicant->addresses->address_mobile,
                    'deleted_email' => $applicant->addresses->address_email,
                    'deleted_createdtime' => now()->format('Y-m-d H:i:s')
                ]);
                /* Save delete logs - End */

                $applicant->delete();

            }
        }
    }
}
