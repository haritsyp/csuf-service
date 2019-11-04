<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $primaryKey = 'service_id';

    public $timestamps = true;
    
    public $incrementing = false;

    protected $fillable = [
        'service_id','service_name','created_at','updated_at'
    ];
}
