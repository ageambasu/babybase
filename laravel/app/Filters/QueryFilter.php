<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;

    protected $builder;

    /**
     * QueryFilters constructor.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Applies selected filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return built filters 
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

    /**
     * Returns selected filters.
     *
     * @return selected filters
     */
    public function filters()
    {
        return $this->request->all();
    }
}