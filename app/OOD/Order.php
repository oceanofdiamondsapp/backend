<?php

namespace OOD;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Specify a primary key.
     * 
     * @var string
     */
    protected $primaryKey = 'pp_transaction_id';

    /**
     * Properties to append to the json object.
     * 
     * @var array
     */
    protected $appends = ['address'];

    /**
     * The properties that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'pp_ship_to_addr_status',
        'pp_ship_to_addr_state',
        'pp_ship_to_addr_line1',
        'pp_ship_to_addr_line2',
        'pp_ship_to_addr_name',
        'pp_ship_to_addr_city',
        'pp_ship_to_addr_zip',
        'pp_transaction_id',
        'pp_gross_amount',
        'pp_payer_status',
        'pp_payer_email',
        'pp_payer_name',
        'pp_fee_amount',
        'pp_tax_amount',
        'order_number',
        'tracking_url',
        'pp_payer_id',
        'status_id',
        'pp_token',
    ];

    /**
     * Update these entities updated_at timestamps.
     * 
     * @var array
     */
    protected $touches = ['quote'];

    /**
     * An order belong to a specific quote.
     * 
     * @return BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo('OOD\Quotes\Quote');
    }

    /**
     * An order has a status.
     * 
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('OOD\Status');
    }

    /**
     * An order can have many messages.
     *
     * @return MorphMany
     */
    public function messages()
    {
        return $this->morphMany('OOD\Message', 'messageable');
    }

    /**
     * An order can have many notes.
     *
     * @return MorphMany
     */
    public function notes()
    {
        return $this->morphMany('OOD\Note', 'noteable');
    }

    /**
     * Full version of the address.
     * 
     * @return string
     */
    public function getAddressAttribute()
    {
        return $this->pp_ship_to_addr_line1 . ' ' .
                   ($this->pp_ship_to_addr_line2 ? $this->pp_ship_to_addr_line2 . ' ' : '') .
                   $this->pp_ship_to_addr_city . ', ' .
                   $this->pp_ship_to_addr_state . ' ' .
                   $this->pp_ship_to_addr_zip;
    }
}
