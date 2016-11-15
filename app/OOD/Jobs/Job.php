<?php

namespace OOD\Jobs;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'carat',
        'budget',
        'ship_to_state',
        'notes',
        'is_active'
    ];

    /**
     * Append non-db column attributes to model's array.
     * 
     * @var array
     */
    protected $appends = ['job_number'];

    /**
     * Properties that should be converted to Carbon instances.
     * 
     * @var array
     */
    protected $dates = ['deadline'];

    /**
     * A request can have many quotes generated for it.
     *
     * @return HasMany
     */
    public function quotes()
    {
        return $this->hasMany('OOD\Quotes\Quote');
    }

    /**
     * A request can include many stones. Stones can also be used by
     * many requests. This relationship is implemented through the
     * 'requests_stones' table.
     *
     * @return BelongsToMany
     */
    public function stones()
    {
        return $this->belongsToMany('OOD\Jobs\Stone', 'jobs_stones');
    }

    /**
     * A request can include many metals. Metals can also be used by
     * many requests. This relationship is implemented through the
     * 'requests_metals' table.
     *
     * @return BelongsToMany
     */
    public function metals()
    {
        return $this->belongsToMany('OOD\Jobs\Metal', 'jobs_metals');
    }

    /**
     * A job can have images. 
     *
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany('OOD\Image', 'imageable');
    }

    /**
     * A request belongs to a specific account.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('OOD\Users\Account');
    }

    /**
     * A request belongs to a specific status.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('OOD\Status');
    }

    /**
     * A request can have many messages.
     *
     * @return MorphMany
     */
    public function messages()
    {
        return $this->morphMany('OOD\Message', 'messageable');
    }

    /**
     * A job has many events associated with it.
     * 
     * @return HasMany
     */
    public function events()
    {
        return $this->hasMany('OOD\Jobs\Event');
    }

    /**
     * A job has many orders through quotes.
     * 
     * @return HasManyThrough
     */
    public function orders()
    {
        return $this->hasManyThrough('OOD\Order', 'OOD\Quotes\Quote');
    }

    /**
     * Get the job number attribute. This is a specific format for
     * Ocean of Diamonds but is not actually stored anywhere in
     * the database.
     *
     * Format: YY##### (Example: 1500001)
     */
    public function getJobNumberAttribute()
    {
        return $this->created_at->format('y') . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get a comma separated list of stones on the request. If no stones
     * were selected, return 'None'
     * 
     * @return string
     */
    public function getCommaSeparatedStoneListAttribute()
    {
        return $this->stones->implode('description', ', ') ?: 'None';
    }

    /**
     * Get a comma separated list of metals on the request. If no
     * metals were selected, return 'None'
     * 
     * @return string
     */
    public function getCommaSeparatedMetalListAttribute()
    {
        return $this->metals->implode('description', ', ') ?: 'None';
    }

    /**
     * Get a boolean for whether or not the job is expiring within the next 7 days.
     * 
     * @return [type]
     */
    public function getIsExpiringSoonAttribute()
    {
        foreach ($this->quotes as $quote) {
            if (date('Y-m-d H:i:s', strtotime('+7 days')) > $quote->expires_at) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a boolean for whether or not the job has one or more orders.
     * 
     * @return boolean
     */
    public function gethasOrdersAttribute()
    {
        return count($this->orders);
    }

    /**
     * Get the budget formatted with comma thousands separater.
     * 
     * @return string
     */
    public function getBudgetFormattedAttribute()
    {
        if ($this->budget < 100)
            return '<$100';
        if ($this->budget < 501)
            return '$100 - $500';
        if ($this->budget < 1001)
            return '$501 - $1000';
        if ($this->budget < 2001)
            return '$1001 - $2000';
        if ($this->budget < 3001)
            return '$2001 - $3000';
        if ($this->budget < 4001)
            return '$3001 - $4000';
        if ($this->budget < 5001)
            return '$4001 - $5000';
        return '> $5000';
    }
}
