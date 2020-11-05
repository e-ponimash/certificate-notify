<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $dates = ['expired_at', 'notified_at'];
    protected $guarded = [];
}
