<?php

namespace App\Models\Eloquent\Scopes;

use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope as ScopeInterface;
use Illuminate\Database\Eloquent\Model;

class FilterBasedOnRoleScope implements ScopeInterface
{
    public function apply(Builder $builder, Model $model)
    {
        $column = $model->getQualifiedCountryColumn();

        if(\Entrust::hasRole('admin_nl')){
            $builder->where($column, '=', 'NL');
        }elseif(\Entrust::hasRole('admin_be')){
            $builder->where($column, '!=', 'NL');
        }

        $this->addWithoutFilterBasedOnRole($builder);
    }

    public function remove(Builder $builder, Model $model) {

        $query  = $builder->getQuery();
        $column = $model->getQualifiedCountryColumn();

        // here you remove the where close to allow developer load
        // without your global scope condition

        foreach ((array) $query->wheres as $key => $where)
        {
            // If the where clause is a soft delete date constraint, we will remove it from
            // the query and reset the keys on the wheres. This allows this developer to
            // include deleted model in a relationship result set that is lazy loaded.
            if ($this->FilterBasedOnRoleTrait($where, $column))
            {
                unset($query->wheres[$key]);

                $query->wheres = array_values($query->wheres);
            }
        }
    }

    /**
     * Check if given where is the scope constraint.
     *
     * @param  array   $where

     * @return boolean
     */
    protected function FilterBasedOnRoleTrait(array $where, $column)
    {
        return ($where['type'] == 'Basic' && $where['column'] == $column);
    }


    /**
     * Extend Builder with custom method.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $builder
     */
    protected function addWithoutFilterBasedOnRole(Builder $builder)
    {
        $builder->macro('withoutFilterBasedOnRole', function(Builder $builder)
        {
            $this->remove($builder, $builder->getModel());

            return $builder;
        });
    }
}