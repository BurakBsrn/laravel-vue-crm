<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Nicolaslopezj\Searchable\SearchableTrait;

trait SearchableTraitWithTurkish
{
    use SearchableTrait;

    public function scopeSearchTurkish(Builder $q, $search, $threshold = null, $entireText = false, $entireTextOnly = false): Builder
    {
        $search	= str_replace(['I', 'İ'], ['ı','i'], $search);
        return $this->scopeSearchRestricted($q, $search, null, $threshold, $entireText, $entireTextOnly);
    }

}
