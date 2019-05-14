<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'amount', 'minimum_order_quantity', 'discount_percent', 'expires_at', 'vouchercode'];
    protected $dates = ['expires_at', 'created_at', 'updated_at'];
}
