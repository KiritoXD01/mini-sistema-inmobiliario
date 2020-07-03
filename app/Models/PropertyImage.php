<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    /**
     * The table that relates to this model
     */
    protected $table = "property_images";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'property_id'
    ];

    /**
     * Get the property
     */
    public function property()
    {
        return $this->belongsTo('App\Models\Property', 'property_id', 'id')->with([
            'id' => 0,
            'name' => 'Undefined'
        ]);
    }
}
