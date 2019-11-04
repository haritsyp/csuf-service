<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'polls';

    protected $primaryKey = 'poll_id';

    public $timestamps = true;
    
    public $incrementing = true;

    protected $fillable = [
        'poll_date','value','service_id','poll_image','created_at','updated_at'
    ];
}
