<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantExperiences extends Model
{
    use HasFactory;
    protected $table = 'applicant_experiences';
    protected $primaryKey = null;
    public $incrementing = false;
}
