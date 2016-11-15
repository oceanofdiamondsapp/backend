<?php

namespace OOD\Jobs;

use Illuminate\Database\Eloquent\Model;

class Stone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * Get the stone name description formated as inital caps words.
     * 
     * @param  string $description 
     * @return string
     */
    public function getDescriptionAttribute($description)
    {
        return ucwords(strtolower($description));
    }
}
