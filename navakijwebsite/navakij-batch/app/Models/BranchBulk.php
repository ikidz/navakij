<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchBulk extends Model
{
    use HasFactory;
    protected $guarded = [];
    const CREATED_AT = 'bulk_createdtime';
    const UPDATED_AT = 'bulk_updatedtime';
    protected $primaryKey = 'bulk_id';
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->bulk_createdip=request()->ip();
        });
        static::updating(function ($model) {
            $model->bulk_updatedip=request()->ip();
        });
    }
    public function scopePending($query)
    {
        return $query->where("bulk_status","pending");
    }
    public function scopeError($query)
    {
        return $query->where("bulk_status","error");
    }
}
