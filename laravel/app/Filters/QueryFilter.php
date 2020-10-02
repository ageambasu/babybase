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
     * Returns selected filters.
     *
     * @return selected filters
     */
    public function filters()
    {
        return $this->request->all();
    }

    /**
     * Applies selected filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return built filters 
     */
    /*public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {

            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        //Exception for studies
        $filters = $this->filters();
        $totalStudyFilters = 0;
        
        foreach ($filters as $filter => $value) {
            if (substr( $filter, 0, 6 ) === "study_" && $value !== NULL) {
                $totalStudyFilters++;
            }
        }

        if ($totalStudyFilters > 0) {
            //Execute the appropiate filter(s)
            switch ($filters) {
                case ( $filters['study_type'] !==NULL ):
                case ( $filters['study_name'] !==NULL ):
                case ( $filters['study_age_range_start'] !==NULL ):
                case ( $filters['study_age_range_end'] !==NULL ):
                    echo 'hola';
                    break;
            }
        } else {
            return $this->builder;
        }
    }*/
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) { // aquí busca el nombre del filtro recibido como el nombre de función en $this existente. y eso como se lo hacemos hacer en el controlador?
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;

    }
}