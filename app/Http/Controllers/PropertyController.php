<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:property-list|property-create|property-edit|property-delete|property', ['only' => ['index','store']]);
        $this->middleware('permission:property-show', ['only' => ['show']]);
        $this->middleware('permission:property-create', ['only' => ['create','store']]);
        $this->middleware('permission:property-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:property', ['only' => ['changeStatus']]);
        $this->middleware('permission:property-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $properties = Property::all();
        return view('property.index', compact('properties'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('property.create');
    }
}
