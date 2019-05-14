<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Molliepayment extends Model
{
    protected $fillable = ['payment_id', 'is_paid', 'status', 'payment_code', 'order_id'];

    public function Orders()
    {
        return $this->belongsTo('App\Order');
    }
}
