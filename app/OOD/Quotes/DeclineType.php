<?php

namespace OOD\Quotes;

use Illuminate\Database\Eloquent\Model;

class DeclineType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * A decline reason can be used for many quotes.
     *
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany('OOD\Quotes\Quote');
    }

    /**
     * Format the decline reason.
     * 
     * @param  string $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return ucfirst(strtolower($value));
    }
}
