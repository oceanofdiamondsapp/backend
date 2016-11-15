<?php

namespace OOD\Jobs;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['description'];

    protected $appends = ['created_on_date'];

    public function user()
    {
        return $this->belongsTo('OOD\Users\User');
    }

    public function job()
    {
        return $this->belongsTo('OOD\Jobs\Job');
    }

    public function getCreatedOnDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
