<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $timestamp = false;
    protected $table = "tambon";
    protected $primaryKey = 'tambon_id';
}
