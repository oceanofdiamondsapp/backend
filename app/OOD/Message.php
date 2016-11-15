<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * A message is written by a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('OOD\Users\User');
    }

    /**
     * A message can belong to a messageable model. For instance,
     * a quote can have a message, and a request can also have
     * a message.
     * 
     * @return MorphTo
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * A message can have images. 
     *
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany('OOD\Image', 'imageable');
    }
}
