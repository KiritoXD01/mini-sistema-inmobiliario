<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProperty extends Model
{
    /**
     * The table that relates to this model
     */
    protected $table = "seller_properties";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'property_id'
    ];

    /*
     * Get the user that has the property
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the property
     */
    public function property()
    {
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }
}
