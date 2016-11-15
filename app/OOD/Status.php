<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The properties that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * A status can have many jobs.
     *
     * @return HasMany
     */
    public function jobs()
    {
        return $this->hasMany('OOD\Jobs\Job');
    }

    /**
     * A status can have many quotes.
     *
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany('OOD\Quotes\Quote');
    }

    /**
     * A status can have many orders.
     * 
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany('OOD\Order');
    }

    /**
     * Get the status attributes.
     *
     * @param  string $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return ucfirst(strtolower($value));
    }
}
