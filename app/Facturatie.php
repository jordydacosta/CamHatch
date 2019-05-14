<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturatie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = ['track_number', 'deliver_date', 'description'];

    /**
     * Get the question that owns the choice.
     */
    public function question()
    {
        return $this->belongsTo('App\Order');
    }
}
