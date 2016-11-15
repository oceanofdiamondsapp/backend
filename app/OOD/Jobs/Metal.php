<?php

namespace OOD\Jobs;

use Illuminate\Database\Eloquent\Model;

class Metal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * A metal can have many requests. Requests can also have
     * many metals. This relationship is implemented
     * through the 'requests_metals' table.
     *
     * @return BelongsToMany
     */
    public function requests()
    {
        return $this->belongsToMany('OOD\Jobs\Job', 'jobs_metals');
    }

    /**
     * A metal can have many quotes. Quotes can also have
     * many metals. This relationship is implemented
     * through the 'quotes_metals' table.
     *
     * @return BelongsToMany
     */
    // public function quotes()
    // {
    // 	return $this->belongsToMany('App\Quote', 'jobs_metals');
    // }

    /**
     * Get the metal name description formated as inital caps words.
     * 
     * @param  string $description 
     * @return string
     */
    public function getDescriptionAttribute($description)
    {
        return ucwords(strtolower($description));
    }
}
