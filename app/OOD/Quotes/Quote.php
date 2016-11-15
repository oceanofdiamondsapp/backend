<?php

namespace OOD\Quotes;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'stones_description',
        'metals_description',
        'setting_details',
        'size_details',
        'other_details',
        'price',
        'shipping',
        'expires_at',
        'quote_number'
    ];

    /**
     * Treat attributes as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['expires_at'];

    /**
     * Update these entities updated_at timestamps.
     *
     * @var array
     */
    protected $touches = ['job'];

    /**
     * Properties to add to the model json.
     *
     * @var array
     */
    protected $appends = ['tax_due', 'total_due'];

    /**
     * A quote belongs to a job. That is, many quotes
     * can be created based off of a single job.
     *
     * @return BelongsTo
     */
    public function job()
    {
        return $this->belongsTo('OOD\Jobs\Job');
    }

    /**
     * A quote belongs to a jewelry type.
     *
     * @return BelongsTo
     */
    public function jewelryType()
    {
        return $this->belongsTo('OOD\JewelryType');
    }

    /**
     * A quote belongs to a status. Quotes should be
     * either 'saved' or 'quoted' only.
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('OOD\Status');
    }

    /**
     * A quote belongs to a tax id.
     *
     * @return BelongsTo
     */
    public function tax()
    {
        return $this->belongsTo('OOD\Tax');
    }

    /**
     * A quote is created by a user. Note that only OOD
     * admin users create quotes. A regular app user
     * will not ever do this.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('OOD\Users\User');
    }

    /**
     * A quote can have a decline type, like 'too expensive'
     * or 'just looking.'
     *
     * @return BelongsTo
     */
    public function declineType()
    {
        return $this->belongsTo('OOD\Quotes\DeclineType');
    }

    /**
     * A quote is noteable, that is, it can have many notes.
     * This is implemented through a polymorphic
     * relationship on the notes table.
     *
     * @return MorphMany
     */
    public function notes()
    {
        return $this->morphMany('OOD\Note', 'noteable');
    }

    /**
     * A quote can have many orders created from it.
     *
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany('OOD\Order');
    }

    /**
     * A quote is messageable, that is, it can have many messages.
     * This is implemented through a polymorphic relationship
     * on the messages table.
     *
     * @return MorphMany
     */
    public function messages()
    {
        return $this->morphMany('OOD\Message', 'messageable');
    }

    /**
     * Get the total amount of tax due.
     *
     * @return float
     */
    public function getTaxDueAttribute()
    {
        return ($this->price + $this->shipping) * $this->tax->amount;
    }

    /**
     * Get the total amount of tax due.
     *
     * @return float
     */
    public function getTaxDueFormattedAttribute()
    {
        return '$' . number_format($this->tax_due, 2, '.', ',');
    }

    /**
     * Get the total price of the quote.
     *
     * @return float
     */
    public function getTotalDueAttribute()
    {
        $total = $this->price + $this->tax_due + $this->shipping;

        return number_format($total, 2);
    }

    /**
     * Get the total price of the quote formatted with dollar sign,
     * commas and two decimal places.
     *
     * @return string
     */
    public function getTotalDueFormattedAttribute()
    {
        return '$' . number_format($this->price + $this->tax_due + $this->shipping, 2, '.', ',');
    }

    /**
     * Get the price formatted with a dollar sign, commas,
     * and two decimal places.
     *
     * @return str
     */
    public function getPriceFormattedAttribute()
    {
        return '$' . number_format($this->price, 2, '.', ',');
    }

    /**
     * Get the shipping price formatted with a dollar sign,
     * commas, and two decimal places.
     *
     * @return str
     */
    public function getShippingFormattedAttribute()
    {
        return '$' . number_format($this->shipping, 2, '.', ',');
    }
}
