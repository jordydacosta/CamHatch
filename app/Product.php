<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function tax() {
        return $this->belongsTo('App\Tax');
    }
}
