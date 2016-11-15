<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * A note is written by a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('OOD\Users\User');
    }

    /**
     * A note can belong to either an account model or a quote model.
     * 
     * @return MorphTo
     */
    public function noteable()
    {
        return $this->morphTo();
    }
}
