<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $guarded = [];
    const CREATED_AT = 'branch_createdtime';
    const UPDATED_AT = 'branch_updatedtime';
    protected $primaryKey = 'branch_id';
    protected $table = 'branches';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->branch_createdip=request()->ip();
        });
        static::updating(function ($model) {
            $model->branch_updatedip=request()->ip();
        });
    }

}
