<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = ['description', 'amount'];
}
