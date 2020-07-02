<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The table that relates to this model
     */
    protected $table = "properties";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'description', 'price',
        'status', 'property_status_id', 'property_type_id',
        'property_legal_condition_id', 'country_id',
        'city_id', 'created_by', 'currency_id'
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
     * Get the property status
     */
    public function propertyStatus()
    {
        return $this->belongsTo('App\Models\PropertyStatus', "property_status_id", 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }

    /*
     * Get the property type
     */
    public function propertyType()
    {
        return $this->belongsTo('App\Models\PropertyType', 'property_type_id', 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }

    /*
     * Get the property legal condition
     */
    public function propertyLegalCondition()
    {
        return $this->belongsTo('App\Models\PropertyLegalCondition', 'property_legal_condition_id', 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }

    /*
     * Get the property country
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }

    /*
     * Get the property city
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }

    /*
     * Get the currency of the property
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'id')->withDefault([
            'id'   => 0,
            'name' => 'Undefined'
        ]);
    }
}
