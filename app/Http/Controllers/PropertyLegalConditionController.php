<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyLegalConditionController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:property-legal-list|property-legal-create|property-legal-edit|property-legal-delete|property-legal-status', ['only' => ['index','store']]);
        $this->middleware('permission:property-legal-show', ['only' => ['show']]);
        $this->middleware('permission:property-legal-create', ['only' => ['create','store']]);
        $this->middleware('permission:property-legal-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:property-legal-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:property-legal-delete', ['only' => ['destroy']]);
    }
}
