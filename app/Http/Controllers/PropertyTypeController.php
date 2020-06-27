<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PropertyTypeController extends Controller
{
    public function __construct()
    {
        /**
         * Sets the permissions for this controller
         */
        $this->middleware('permission:property-type-list|property-type-create|property-type-edit|property-type-delete|property-type-status', ['only' => ['index','store']]);
        $this->middleware('permission:property-type-show', ['only' => ['show']]);
        $this->middleware('permission:property-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:property-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:property-type-status', ['only' => ['changeStatus']]);
        $this->middleware('permission:property-type-delete', ['only' => ['destroy']]);
    }

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $propertyTypes = PropertyType::all();
        return view('propertyType.index', compact('propertyTypes'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('propertyType.create');
    }

    /**
     * Show the edit view with the item information
     * @param PropertyType $propertyType
     * @method GET
     */
    public function edit(PropertyType $propertyType)
    {
        return view('propertyType.edit', compact('propertyType'));
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param PropertyType $propertyType
     * @method GET
     */
    public function show(PropertyType $propertyType)
    {
        return view('propertyType.show', compact('propertyType'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
         Validator::make($request->all(), [
             'name' => ['required', 'string', 'max:255', 'unique:property_types,name']
         ])->validate();

         $data               = $request->all();
         $data['name']       = strtoupper($data['name']);
         $data['created_by'] = auth()->user()->id;

         $propertyType = PropertyType::create($data);

        return redirect()
            ->route('propertyType.edit', compact('propertyType'))
            ->with('success', trans('messages.propertyTypeCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param PropertyType $propertyType
     * @method PATCH
     */
    public function update(Request $request, PropertyType $propertyType)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('property_types')->ignoreModel($propertyType)]
        ])->validate();

        $propertyType->update($request->all());

        return redirect()
            ->route('propertyType.edit', compact('propertyType'))
            ->with('success', trans('messages.propertyTypeUpdated'));
    }
}
