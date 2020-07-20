<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('activity.index', compact('activities'));
    }
}
