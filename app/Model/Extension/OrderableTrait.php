<?php

namespace App\Model\Extension;

trait OrderableTrait
{

    /**
     * Scope to order ascending by `order` field and `created_at` desc
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAsc($query)
    {
        return $query->orderBy('order', 'ASC')->latest('created_at');
    }

    /**
     * Scope to order descending by `order` field and `created_at` asc
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDesc($query)
    {
        return $query->orderBy('order', 'DESC')->oldest('created_at');
    }
}
