<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = ['country_en', 'country_nl', 'isocode', 'continents'];

    /**
     * Get the question that owns the choice.
     */
    public function order() {

            return $this->hasMany('App\Order');
    }
}
