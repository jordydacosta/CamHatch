<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Eloquent\Scopes\FilterBasedOnRoleTrait;

class Order extends Model
{
	use SoftDeletes, FilterBasedOnRoleTrait;

    protected $guarded = array();
    protected $dates = ['delivery_date'];

    /*
    |--------------------------------------------------------------------------
    | Event listeners
    |--------------------------------------------------------------------------
    |
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function($order)
        {
            $orderId = $order->getAttribute('id') . date('y').date('m').date('d').date('h').date('i').date('s');
            $order->orderId = $orderId;
        });
    }

    public function scopeOrderType($query, $orderstatus_id)
    {
        $query->where(function($query) use($orderstatus_id) {
                    $query->whereIn('orders.orderstatus_id', $orderstatus_id);
                });
    }

    public function country(){

        return $this->belongsTo('App\Country');

    }


}
