<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table that relates to this model
     */
    protected $table = "countries";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'iso', 'status', 'created_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the current user's creator
     */
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id')->withDefault([
            'full_name' => "SYSTEM"
        ]);
    }

    /**
     * Relation between the country and its cities
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City', 'country_id', 'id');
    }
}