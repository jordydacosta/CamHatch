<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = ['quantity', 'price', 'tax' ,'invoice_id'];

    /**
     * Get the question that owns the choice.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function invoice_lines() {
        return $this->hasMany('App\InvoiceLine');
    }

}
