<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellAgents extends Model
{
    use HasFactory;
    protected $guarded = [];
    const CREATED_AT = 'agent_createdtime';
    const UPDATED_AT = 'agent_updatedtime';
    protected $primaryKey = 'agent_id';
    protected $table = 'sell_agents';
    protected $fillable = [
        'agent_name_th',
        'agent_name_en',
        'agent_license_no',
        'agent_status',
        'agent_createdip'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->agent_createdip=request()->ip();
        });
        static::updating(function ($model) {
            $model->agent_updatedip=request()->ip();
        });
    }
}
