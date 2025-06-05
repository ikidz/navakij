<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantLanguageSkills extends Model
{
    use HasFactory;
    protected $table = 'applicant_language_skills';
    protected $primaryKey = null;
    public $incrementing = false;
}
