<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The properties that should be mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];

    /**
     * An image is uploaded by a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('OOD\Users\User');
    }

    /**
     * An image can belong to a imageable model.
     * 
     * @return MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Get the full path to the uploaded file.
     *
     * @return string
     */
    public function getPathAttribute($path)
    {
        return "/$path";
    }
}
