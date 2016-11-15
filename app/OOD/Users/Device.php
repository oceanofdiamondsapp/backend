<?php

namespace OOD\Users;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_id',
        'token',
        'platform',
    ];
}
