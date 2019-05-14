<?php namespace App\Models\Eloquent\Scopes;

/**
 * Created by IntelliJ IDEA.
 * User: smailhammour
 * Date: 16/02/2017
 * Time: 22:07
 */
trait FilterBasedOnRoleTrait {

    /**
     * Boot the Active Events trait for a model.
     *
     * @return void
     */
    public static function bootFilterBasedOnRoleTrait()
    {
        static::addGlobalScope(new FilterBasedOnRoleScope);
    }


    /**
     * Get the name of the column for applying the scope.
     *
     * @return string
     */
    public function getCountryColumn()
    {
        return defined('static::COUNTRY_COLUMN') ? static::COUNTRY_COLUMN : 'country';
    }

    /**
     * Get the fully qualified column name for applying the scope.
     *
     * @return string
     */
    public function getQualifiedCountryColumn()
    {
        return $this->getTable().'.'.$this->getCountryColumn();
    }

    /**
     * Get the query builder without the scope applied.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withoutFilterBasedOnRole()
    {
        return with(new static)->newQueryWithoutScope(new FilterBasedOnRoleScope);
    }

}