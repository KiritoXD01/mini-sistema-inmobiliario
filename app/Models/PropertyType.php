<?php

namespace App\Models;

use App\Enums\LogType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PropertyType extends Model
{
    use LogsActivity;

    /**
     * The table that relates to this model
     */
    protected $table = "property_types";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'created_by'
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
     * Set the attributes that will be logged
     */
    protected static $logFillable  = true;

    /**
     * Set the log name
     */
    protected static $logName = LogType::PROPERTY_TYPE_LOG;

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
}
