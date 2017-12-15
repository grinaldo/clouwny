<?php

namespace App\Model\Extension;

use Carbon\Carbon;

trait PublishableTrait
{

    /**
     * Scope to add condition `published_at` is not null. (Published model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Scope to add condition `published_at` is null. (Unpublished Model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at');
    }

    /**
     * Scope to add condition `published_at` sorted by latest update. (Unpublished Model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('published_at', 'DESC');
    }

    /**
     * Scope to add condition `published_at` sorted by oldest update. (Unpublished Model)
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('published_at', 'ASC');
    }

    /**
     * Set `published_at` attributes given true or false value.
     * If true `published_at` will be set to current datetime, null otherwise.
     * @param boolean
     */
    public function setPublishedAttribute($value)
    {
        if ($value) {
            if (!$this->published) {
                $this->published_at = new Carbon;
            }
        } else {
            $this->published_at = null;
        }
    }

    /**
     * Get published flag.
     * @return boolean
     */
    public function getPublishedAttribute()
    {
        return $this->published_at == true;
    }
}
