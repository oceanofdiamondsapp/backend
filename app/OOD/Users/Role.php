<?php

namespace OOD\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $fillable = ['name'];

    /**
     * A role can have many users associated with it.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('OOD\Users\User', 'users_roles')->withTimestamps();
    }
}
