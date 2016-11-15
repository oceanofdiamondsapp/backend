<?php

namespace OOD\Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * A user can create many Quotes. Note only admin
     * users can actually create a quote. Regular
     * app users will never do this.
     *
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany('OOD\Quotes\Quote')->orderBy('updated_at', 'DESC');
    }

    /**
     * A user can have many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('OOD\Users\Role', 'users_roles')->withTimestamps();
    }

    /**
     * A user can write many notes.
     *
     * @return HasMany
     */
    public function notes()
    {
        return $this->hasMany('OOD\Note');
    }

    /**
     * A user can generate many events.
     * 
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany('OOD\Event');
    }

    /**
     * A user can have many devices registered for push notifications.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany('OOD\Users\Device');
    }

    /**
     * The user has a specific role.
     *
     * @param  string  $role
     * @return boolean
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == strtoupper($name)) {
                return true;
            }
        }

        return false;
    }
}
