<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $guarded = ['id'];

    /**
     * Get the question that owns the choice.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function products() {
        return $this->belongsTo('App\Product');
    }

}