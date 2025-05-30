<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedData extends Model
{
    use HasFactory;
    protected $table = 'deleted_data';
    protected $primaryKey = 'deleted_id';
    const CREATED_AT = 'deleted_created';
    protected $fillable = [
        'deleted_name',
        'deleted_idcard',
        'deleted_tel',
        'deleted_email',
        'deleted_createdtime',
        'deleted_createdip'
    ];
    protected $casts = [
        'deleted_createdtime' => 'datetime'
    ];

    protected static function booted(){
        self::creating(function( $model ){
            $model->deleted_createdip=request()->ip();
        });
    }
}
