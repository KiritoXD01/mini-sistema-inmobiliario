<?php

namespace App\Http\Controllers;

use App\Models\PropertyStatus;
use Illuminate\Http\Request;

class PropertyStatusController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:property-status-list|property-status-create|property-status-edit|property-status-delete|property-status-status', ['only' => ['index','store']]);
        $this->middleware('permission:property-status-show', ['only' => ['show']]);
        $this->middleware('permission:property-status-create', ['only' => ['create','store']]);
        $this->middleware('permission:property-status-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:property-status-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:property-status-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $allPropertyStatus = PropertyStatus::all();
        return view('propertyStatus.index', compact('allPropertyStatus'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('propertyStatus.create');
    }

    /**
     * Show the edit view with the item information
     * @param PropertyStatus $propertyStatus
     * @method GET
     */
    public function edit(PropertyStatus $propertyStatus)
    {
        return view('propertyStatus.edit', compact('propertyStatus'));
    }
}
