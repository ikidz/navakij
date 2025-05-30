<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicantExperiences;
use App\Models\ApplicantLanguageSkills;
use App\Models\ApplicantAddresses;

class Applicants extends Model
{
    use HasFactory;
    protected $table = 'applicants';
    protected $primaryKey = 'applicant_id';

    protected static function booted(){
        static::deleting(function ($model) {

            /* Addresses - Start */
            ApplicantAddresses::where([
                'applicant_id' => $model->id
            ])->delete();
            /* Addresses - End */

            /* Experiences - Start */
            ApplicantExperiences::where([
                'applicant_id' => $model->id
            ])->delete();
            /* Experiences - End */

            /* Language Skills - Start */
            ApplicantLanguageSkills::where([
                'applicant_id' => $model->id
            ])->delete();
            /* Language Skills - End */
            
        });
    }

    public function addresses(){
        return $this->hasOne('App\Models\ApplicantAddresses', 'applicant_id','applicant_id');
    }
}
