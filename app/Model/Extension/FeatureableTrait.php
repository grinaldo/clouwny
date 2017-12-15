<?php

namespace App\Model\Extension;

trait FeaturableTrait
{

    /**
     * Scope to add condition `is_featured` is true. (Featured model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to add condition `is_featured` is false. (UnFeatured Model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnfeatured($query)
    {
        return $query->where('is_featured', false);
    }
}
