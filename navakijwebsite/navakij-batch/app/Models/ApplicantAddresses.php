<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAddresses extends Model
{
    use HasFactory;
    protected $table = 'applicant_addresses';
    protected $primaryKey = null;
    public $incrementing = false;
}
