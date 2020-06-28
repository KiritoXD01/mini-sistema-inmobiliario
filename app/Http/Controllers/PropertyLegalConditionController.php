<?php

namespace App\Http\Controllers;

use App\Models\PropertyLegalCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    /**
     * Show the index view
     * @method GET
     */
    public function index()
    {
        $propertyLegalConditions = PropertyLegalCondition::all();
        return view('propertyLegalCondition.index', compact('propertyLegalConditions'));
    }

    /**
     * Show the create view
     * @method GET
     */
    public function create()
    {
        return view('propertyLegalCondition.create');
    }

    /**
     * Show the edit view with the item information
     * @param PropertyLegalCondition $propertyLegalCondition
     * @method GET
     */
    public function edit(PropertyLegalCondition $propertyLegalCondition)
    {
        return view('propertyLegalCondition.edit', compact('propertyLegalCondition'));
    }

    /**
     * Display the show view with the item information in readonly mode
     * @param PropertyLegalCondition $propertyLegalCondition
     * @method GET
     */
    public function show(PropertyLegalCondition $propertyLegalCondition)
    {
        return view('propertyLegalCondition.show', compact('propertyLegalCondition'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:property_legal_conditions,name']
        ])->validate();

        $data               = $request->all();
        $data['name']       = strtoupper($data['name']);
        $data['created_by'] = auth()->user()->id;

        $propertyLegalCondition = PropertyLegalCondition::create($data);

        return redirect()
            ->route('propertyLegalCondition.edit', compact('propertyLegalCondition'))
            ->with('success', trans('messages.propertyLegalConditionCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param Request $request
     * @param PropertyLegalCondition $propertyLegalCondition
     * @method PATCH
     */
    public function update(Request $request, PropertyLegalCondition $propertyLegalCondition)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('property_legal_condition')->ignoreModel($propertyLegalCondition)]
        ])->validate();

        $data = $request->all();
        $data['name'] = strtoupper($data['name']);

        $propertyLegalCondition->update($data);

        return redirect()
            ->route('propertyLegalCondition.edit', compact('propertyLegalCondition'))
            ->with('success', trans('messages.propertyLegalConditionUpdated'));
    }

    /**
     * Delete the item
     * @param PropertyLegalCondition $propertyLegalCondition
     * @method DELETE
     */
    public function destroy(PropertyLegalCondition $propertyLegalCondition)
    {
        $propertyLegalCondition->delete();
        return redirect()
            ->route('propertyLegalCondition.index')
            ->with('success', trans('messages.propertyLegalConditionDeleted'));
    }

    /**
     * Change the status of the item
     * @param PropertyLegalCondition $propertyLegalCondition
     * @method POST
     */
    public function changeStatus(PropertyLegalCondition $propertyLegalCondition)
    {
        $propertyLegalCondition = PropertyLegalCondition::find($propertyLegalCondition->id);
        $propertyLegalCondition->update([
            'status' => ($propertyLegalCondition->status) ? 0 : 1
        ]);

        return redirect()
            ->route('propertyLegalCondition.index')
            ->with('success', trans('messages.propertyLegalConditionUpdated'));
    }
}
