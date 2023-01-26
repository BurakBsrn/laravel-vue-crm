<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilters $filter
     */
    public function scopeFilter(Builder $builder, QueryFilters $filter)
    {
        $filter->apply($builder);
    }
}
