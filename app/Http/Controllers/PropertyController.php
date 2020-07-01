<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\PropertyLegalCondition;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $this->middleware('permission:property-status', ['only' => ['changeStatus']]);
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
        $allPropertyStatus       = PropertyStatus::select('id', 'name')->where('status', true)->get();
        $propertyTypes           = PropertyType::select('id', 'name')->where('status', true)->get();
        $propertyLegalConditions = PropertyLegalCondition::select('id', 'name')->where('status', true)->get();
        $countries               = Country::select('id', 'name')->where('status', true)->get();
        $data = [
            'allPropertyStatus'       => $allPropertyStatus,
            'propertyTypes'           => $propertyTypes,
            'propertyLegalConditions' => $propertyLegalConditions,
            'countries'               => $countries
        ];
        return view('property.create', $data);
    }

    /**
     * Get all the cities by the country_id
     * @param Request $request
     * @method GET
     */
    public function getCitiesByCountry(Request $request)
    {
        $country = Country::find($request->country_id);
        return $country->cities()
            ->select('id', 'name')
            ->where('status', true)
            ->get();
    }

    /**
     * Show the edit view with the item information
     * @param Property $property
     * @method GET
     */
    public function edit(Property $property)
    {
        $allPropertyStatus       = PropertyStatus::select('id', 'name')->where('status', true)->get();
        $propertyTypes           = PropertyType::select('id', 'name')->where('status', true)->get();
        $propertyLegalConditions = PropertyLegalCondition::select('id', 'name')->where('status', true)->get();
        $countries               = Country::select('id', 'name')->where('status', true)->get();
        $cities                  = City::select('id', 'name')
                                        ->where([
                                            ['status', true],
                                            ['country_id', $property->country_id]
                                        ])
                                        ->get();
        $data = [
            'allPropertyStatus'       => $allPropertyStatus,
            'propertyTypes'           => $propertyTypes,
            'propertyLegalConditions' => $propertyLegalConditions,
            'countries'               => $countries,
            'property'                => $property,
            'cities'                  => $cities
        ];
        return view('property.edit', $data);
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param Property $property
     * @method GET
     */
    public function show(Property $property)
    {
        return view('property.show', compact('property'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:255', 'unique:properties,code'],
            'price'       => ['required', 'numeric'],
        ])->validate();

        $data               = $request->all();
        $data['code']       = (empty($data['code'])) ? Str::random(8) : $data['code'];
        $data['created_by'] = auth()->user()->id;

        $property = Property::create($data);

        return redirect()
            ->route('property.edit', compact('property'))
            ->with('success', trans('messages.propertyCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param Request $request
     * @param Property $property
     * @method PATCH
     */
    public function update(Request $request, Property $property)
    {
        Validator::make($request->all(), [
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['nullable', 'string', 'max:255', Rule::unique('properties')->ignoreModel($property)],
            'price'       => ['required', 'numeric'],
        ])->validate();

        $data         = $request->all();
        $data['code'] = (empty($data['code'])) ? Str::random(8) : $data['code'];

        $property->update($data);

        return redirect()
            ->route('property.edit', compact('property'))
            ->with('success', trans('messages.propertyUpdated'));
    }

    /**
     * Delete the item
     * @param Property $property
     * @method DELETE
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()
            ->route('property.index')
            ->with('success', trans('messages.propertyDeleted'));
    }

    /**
     * Change the status of the item
     * @param Property $property
     * @method POST
     */
    public function changeStatus(Property $property)
    {
        $property = Property::find($property->id);
        $property->update([
            'status' => ($property->status) ? 0 : 1
        ]);

        return redirect()
            ->route('property.index')
            ->with('success', trans('messages.propertyUpdated'));
    }
}
