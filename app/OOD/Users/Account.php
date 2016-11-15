<?php

namespace OOD\Users;

use Illuminate\Support\Collection;

class Account extends User
{
    /**
     * An account can create many jobs.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany('OOD\Jobs\Job')
                    ->orderBy('updated_at', 'DESC');
    }

    /**
     * An account can have many notes.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->morphMany('OOD\Note', 'noteable')
                    ->orderBy('created_at', 'DESC');
    }

    /**
     * An account can have many roles. In reality, the account model
     * represents a user with a 'user' role. That is, an account
     * should not represent an admin user.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('OOD\Users\Role', 'users_roles', 'user_id')
                    ->withTimestamps();
    }

    /**
     * An account can have many quotes through the request entity.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function quotes()
    {
        return $this->hasManyThrough('OOD\Quotes\Quote', 'OOD\Jobs\Job')
                    ->with('orders', 'orders.status')
                    ->orderBy('updated_at', 'DESC');
    }

    /**
     * A user can have many devices registered for push notifications.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany('OOD\Users\Device', 'user_id');
    }

    /**
     * Get the updated_at date of the most recently updated quote.
     *
     * @return string
     */
    public function getLastQuoteDateAttribute()
    {
        if ($this->quotes->count()) {
            return $this->quotes
                        ->sortByDesc('updated_at')
                        ->flatten()
                        ->first()
                        ->updated_at->format('M j, Y');
        }

        return 'N/A';
    }

    /**
     * Get a collection of orders placed for this account.
     * 
     * @return Illuminate\Support\Collection
     */
    public function getOrdersAttribute()
    {
        $orders = [];

        foreach ($this->quotes as $quote) {
            foreach ($quote->orders as $order) {
                $order->job = $order->quote->job;
                $orders[] = $order;
            }
        }

        return Collection::make($orders);
    }

    /**
     * Get the total amount spent.
     * 
     * @return float
     */
    public function getTotalSpentAttribute()
    {
        $total = 0;

        foreach ($this->orders as $order) {
            $total += $order->pp_gross_amount;
        }

        return '$'. number_format($total, 2, '.', ',');
    }

    /**
     * Get the date of the last order placed for this account.
     * 
     * @return string
     */
    public function getLastOrderDateAttribute()
    {
        if ($this->orders->count()) {
            return $this->orders->sortByDesc(function ($order) {
                return $order->created_at;
            })->first()->created_at->format('M j, Y');
        }

        return 'N/A';
    }
}
