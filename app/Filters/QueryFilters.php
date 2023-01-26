<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], (array)$value);
            }
        }

        if ($this->defaultIncludes) {
            $this->builder->with($this->defaultIncludes);
        }
    }

    /**
     * @return array
     */
    protected function filters(): array
    {
        return array_filter(
            array_map('trim', $this->request->all())
        );
    }

    /**
     * @param $value
     */
    public function searches($value)
    {
        if(!is_null($value) && $this->builder->getModel()->scopeCheckSearchTurkish())
            $this->builder = $this->builder->SearchTurkish($value, 1);
    }

    public function orderBy($value)
    {
        $this->request->validate([
            'sortedBy' => 'required|in:asc,desc',
            'orderBy' => 'required'
        ]);
        $sortedBy = $this->request->get('sortedBy', 'desc');
//        if(!is_null($value) && $this->builder->getModel()->scopeCheckSortable()) {
//            $this->builder = $this->builder->sortable(['asd']);
//        }
        $this->builder->orderBy($value, $sortedBy);
    }

    public function include($value)
    {
        $includes = explode(',', $value);
        foreach ($includes as $item) {
            if(in_array($item, $this->availableIncludes)) {
                $this->builder->with($item);
            }
        }
    }
}
