<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The table that relates to this model
     */
    protected $table = "currencies";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rate', 'status', 'created_by',
        'format_code'
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
}
