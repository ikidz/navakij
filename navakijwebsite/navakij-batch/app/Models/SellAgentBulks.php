<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellAgentBulks extends Model
{
    use HasFactory;
    protected $table = 'sell_agent_bulks';
    protected $fillable = [
        'status',
        'process_time',
        'finished_time',
        'report',
        'remark'
    ];
    protected $casts = [
        'process_time' => 'datetime',
        'finished_time' => 'datetime'
    ];
    public function scopePending($query)
    {
        return $query->where("status","pending");
    }
    public function scopeError($query)
    {
        return $query->where("status","failed");
    }
}
