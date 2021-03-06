<?php

namespace App\Models;

use App\Enums\LogType;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, LogsActivity;

    /**
     * The table that relates to this model
     */
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
        'status', 'phonenumber', 'created_by', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime'
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
     * Get the properties that below this user
     */
    public function propertySellers()
    {
        return $this->hasMany('App\Models\SellerProperty', 'user_id', 'id');
    }

    /**
     * Returns the full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Set the attributes that will be logged
     */
    protected static $logFillable  = true;

    /**
     * Set the log name
     */
    protected static $logName = LogType::USER_LOG;

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
