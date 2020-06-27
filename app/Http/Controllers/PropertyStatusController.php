<?php

namespace App\Http\Controllers;

use App\Models\PropertyStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    /**
     * Display the show view with the item information in readonly mode
     * @param PropertyStatus $propertyStatus
     * @method GET
     */
    public function show(PropertyStatus $propertyStatus)
    {
        return view('propertyStatus.show', compact('propertyStatus'));
    }

    /**
     * Receive the form information and creates the item
     * @param Request $request
     * @method POST
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:property_status,name']
        ])->validate();

        $data               = $request->all();
        $data['name']       = strtoupper($data['name']);
        $data['created_by'] = auth()->user()->id;

        $propertyStatus = PropertyStatus::create($data);

        return redirect()
            ->route('propertyStatus.edit', compact('propertyStatus'))
            ->with('success', trans('messages.propertyStatusCreated'));
    }

    /**
     * Receive the form information and updates the item
     * @param $request
     * @param PropertyStatus $propertyStatus
     * @method PATCH
     */
    public function update(Request $request, PropertyStatus $propertyStatus)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('property_status')->ignoreModel($propertyStatus)]
        ])->validate();

        $data = $request->all();
        $data['name'] = strtoupper($data['name']);

        $propertyStatus->update($data);

        return redirect()
            ->route('propertyStatus.edit', compact('propertyStatus'))
            ->with('success', trans('messages.propertyStatusUpdated'));
    }

    /**
     * Delete the item
     * @param PropertyStatus $propertyStatus
     * @method DELETE
     */
    public function destroy(PropertyStatus $propertyStatus)
    {
        $propertyStatus->delete();
        return redirect()
            ->route('propertyStatus.index')
            ->with('success', trans('messages.propertyStatusDeleted'));
    }

    /**
     * Change the status of the item
     * @param PropertyStatus $propertyStatus
     * @method POST
     */
    public function changeStatus(PropertyStatus $propertyStatus)
    {
        $propertyStatus = PropertyStatus::find($propertyStatus->id);
        $propertyStatus->update([
            'status' => ($propertyStatus->status) ? 0 : 1
        ]);

        return redirect()
            ->route('propertyStatus.edit', compact('propertyStatus'))
            ->with('success', trans('messages.propertyStatusUpdated'));
    }
}
