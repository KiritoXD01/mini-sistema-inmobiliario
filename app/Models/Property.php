<?php

namespace App\Models;

use App\Enums\LogType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Property extends Model
{
    use LogsActivity;

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
        'city_id', 'created_by', 'currency_id', 'bedroom_quantity',
        'bathroom_quantity', 'lounge_quantity', 'parking_quantity',
        'kitchen_quantity', 'property_level', 'has_water',
        'has_heating', 'has_air_conditioning'
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

    /**
     * Get all the images that belongs to the property
     */
    public function propertyImages()
    {
        return $this->hasMany('App\Models\PropertyImage', 'property_id', 'id');
    }

    /**
     * Set the attributes that will be logged
     */
    protected static $logFillable  = true;

    /**
     * Set the log name
     */
    protected static $logName = LogType::PROPERTY_LOG;

    /**
     * Sets the custom description for the log
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $user = (auth()->check()) ? auth()->user()->full_name : "SYSTEM";
        return "This model has been {$eventName} by {$user}";
    }

    /**
     * Get the sellers that have this property
     */
    public function users()
    {
        return $this->hasMany("App\Models\SellerProperty", 'property_id', 'id');
    }
}
